import { useEffect, useState } from "react";
import { memberService } from "../../../services/memberService";
import {
  Button,
  Container,
  Table,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
  Typography,
  CircularProgress,
  Paper,
  Select,
  MenuItem,
  Chip,
} from "@mui/material";
import { useNavigate } from "react-router";
import "./MemberManagerPage.css";

const ESTADO_COLOR = {
  pendiente: "warning",
  activo:    "success",
  rechazado: "error",
};

const FILTROS = [
  { key: "todos",     label: "Todos" },
  { key: "pendiente", label: "Pendientes" },
  { key: "activo",    label: "Activos" },
  { key: "rechazado", label: "Rechazados" },
];

export function MemberManagerPage() {
  const navigate = useNavigate();
  const [members, setMembers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState(null);
  const [filtro, setFiltro] = useState("todos");

  useEffect(() => {
    async function fetchMembers() {
      try {
        const response = await memberService.getMembers();
        setMembers(response.data || []);
      } catch (error) {
        console.error("Error al obtener socios:", error);
      } finally {
        setLoading(false);
      }
    }
    fetchMembers();
  }, []);

  const handleEstadoChange = async (id, nuevoEstado) => {
    setUpdating(id);
    try {
      await memberService.updateEstado(id, nuevoEstado);
      setMembers((prev) =>
        prev.map((m) => (m.id === id ? { ...m, estado: nuevoEstado } : m))
      );
    } catch (error) {
      alert("Error al actualizar el estado del socio.");
      console.error(error);
    } finally {
      setUpdating(null);
    }
  };

  const visibles =
    filtro === "todos" ? members : members.filter((m) => m.estado === filtro);

  return (
    <div className="member-manager-page">
      <Container maxWidth="lg" className="crear-container">
        <Button
          variant="contained"
          className="volver-btn"
          onClick={() => navigate(-1)}
        >
          ← Volver
        </Button>

        <Typography variant="h4" className="title-member">
          Gestión de Socios
        </Typography>

        {/* Filtros por estado */}
        <div className="member-filters">
          {FILTROS.map((f) => (
            <Button
              key={f.key}
              className={
                filtro === f.key ? "filter-btn filter-btn-active" : "filter-btn"
              }
              onClick={() => setFiltro(f.key)}
            >
              {f.label}
            </Button>
          ))}
        </div>

        {loading ? (
          <CircularProgress />
        ) : visibles.length === 0 ? (
          <Typography variant="body1">
            No hay solicitudes para mostrar.
          </Typography>
        ) : (
          <Paper>
            <Table className="member-table">
              <TableHead className="table-header">
                <TableRow>
                  <TableCell><b>ID</b></TableCell>
                  <TableCell><b>Nombre</b></TableCell>
                  <TableCell><b>Apellido</b></TableCell>
                  <TableCell><b>DNI</b></TableCell>
                  <TableCell><b>Email</b></TableCell>
                  <TableCell><b>Teléfono</b></TableCell>
                  <TableCell><b>Domicilio</b></TableCell>
                  <TableCell><b>Nacimiento</b></TableCell>
                  <TableCell><b>Solicitud</b></TableCell>
                  <TableCell><b>Estado</b></TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {visibles.map((m) => (
                  <TableRow className="table-row" key={m.id}>
                    <TableCell data-label="ID">{m.id}</TableCell>
                    <TableCell data-label="Nombre">{m.name}</TableCell>
                    <TableCell data-label="Apellido">{m.surname}</TableCell>
                    <TableCell data-label="DNI">{m.dni}</TableCell>
                    <TableCell data-label="Email">{m.email}</TableCell>
                    <TableCell data-label="Teléfono">{m.phone}</TableCell>
                    <TableCell data-label="Domicilio">{m.address}</TableCell>
                    <TableCell data-label="Nacimiento">
                      {m.birth_date
                        ? new Date(m.birth_date).toLocaleDateString("es-AR")
                        : "-"}
                    </TableCell>
                    <TableCell data-label="Solicitud">
                      {m.fecha_solicitud
                        ? new Date(m.fecha_solicitud).toLocaleDateString("es-AR")
                        : "-"}
                    </TableCell>
                    <TableCell data-label="Estado">
                      {updating === m.id ? (
                        <CircularProgress size={20} />
                      ) : (
                        <Select
                          size="small"
                          value={m.estado}
                          onChange={(e) =>
                            handleEstadoChange(m.id, e.target.value)
                          }
                          renderValue={(val) => (
                            <Chip
                              label={val.charAt(0).toUpperCase() + val.slice(1)}
                              color={ESTADO_COLOR[val] || "default"}
                              size="small"
                            />
                          )}
                        >
                          <MenuItem value="pendiente">Pendiente</MenuItem>
                          <MenuItem value="activo">Activo</MenuItem>
                          <MenuItem value="rechazado">Rechazado</MenuItem>
                        </Select>
                      )}
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </Paper>
        )}
      </Container>
    </div>
  );
}
