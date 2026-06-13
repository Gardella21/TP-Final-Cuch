import { useEffect, useState } from "react";
import { bookReservationService } from "../../../services/bookReservationService";
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
import "./BookReservationManagerPage.css";

const ESTADO_COLOR = {
  pendiente:  "warning",
  confirmada: "success",
  cancelada:  "error",
};

export function BookReservationManagerPage() {
  const navigate = useNavigate();
  const [reservations, setReservations] = useState([]);
  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState(null);

  useEffect(() => {
    async function fetchReservations() {
      try {
        const response = await bookReservationService.getAll();
        setReservations(response.data || []);
      } catch (error) {
        console.error("Error al obtener reservas:", error);
      } finally {
        setLoading(false);
      }
    }
    fetchReservations();
  }, []);

  const handleEstadoChange = async (id, nuevoEstado) => {
    setUpdating(id);
    try {
      await bookReservationService.updateEstado(id, nuevoEstado);
      setReservations((prev) =>
        prev.map((r) => (r.id === id ? { ...r, estado: nuevoEstado } : r))
      );
    } catch (error) {
      alert("Error al actualizar el estado de la reserva.");
      console.error(error);
    } finally {
      setUpdating(null);
    }
  };

  return (
    <div className="book-reservation-manager-page">
      <Container maxWidth="lg" className="crear-container">
        <Button
          variant="contained"
          className="volver-btn"
          onClick={() => navigate(-1)}
        >
          ← Volver
        </Button>

        <Typography variant="h4" className="title-book-reservation">
          Reservas de Libros
        </Typography>

        {loading ? (
          <CircularProgress />
        ) : reservations.length === 0 ? (
          <Typography variant="body1">No hay reservas registradas.</Typography>
        ) : (
          <Paper>
            <Table className="reservation-table">
              <TableHead className="table-header">
                <TableRow>
                  <TableCell><b>ID</b></TableCell>
                  <TableCell><b>Libro</b></TableCell>
                  <TableCell><b>Código</b></TableCell>
                  <TableCell><b>Nombre</b></TableCell>
                  <TableCell><b>Apellido</b></TableCell>
                  <TableCell><b>Email</b></TableCell>
                  <TableCell><b>Teléfono</b></TableCell>
                  <TableCell><b>Fecha</b></TableCell>
                  <TableCell><b>Estado</b></TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {reservations.map((r) => (
                  <TableRow className="table-row" key={r.id}>
                    <TableCell data-label="ID">{r.id}</TableCell>
                    <TableCell data-label="Libro">{r.book_titulo}</TableCell>
                    <TableCell data-label="Código">{r.book_codigo}</TableCell>
                    <TableCell data-label="Nombre">{r.name}</TableCell>
                    <TableCell data-label="Apellido">{r.surname}</TableCell>
                    <TableCell data-label="Email">{r.email}</TableCell>
                    <TableCell data-label="Teléfono">{r.phone}</TableCell>
                    <TableCell data-label="Fecha">
                      {r.fecha_reserva
                        ? new Date(r.fecha_reserva).toLocaleDateString("es-AR")
                        : "-"}
                    </TableCell>
                    <TableCell data-label="Estado">
                      {updating === r.id ? (
                        <CircularProgress size={20} />
                      ) : (
                        <Select
                          size="small"
                          value={r.estado}
                          onChange={(e) =>
                            handleEstadoChange(r.id, e.target.value)
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
                          <MenuItem value="confirmada">Confirmada</MenuItem>
                          <MenuItem value="cancelada">Cancelada</MenuItem>
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