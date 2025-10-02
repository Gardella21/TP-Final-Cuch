import { useEffect, useState } from "react";
import {
  Button,
  Container,
  Typography,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  IconButton,
  TextField,
  Box,
  Alert,
} from "@mui/material";
import { Edit, Delete, CheckCircle, Cancel, ArrowBack } from "@mui/icons-material";

import { userService } from "../../../services/userService";
import UserEditModal from "./UserEditModal";
import "./UserManagerPage.css";

export default function UserManagerPage() {
  const [activeTab, setActiveTab] = useState("requests"); // pestaña activa //
  const [users, setUsers] = useState([]); // usuarios activos //
  const [requests, setRequests] = useState([]); // solicitudes pendientes //
  const [search, setSearch] = useState(""); // buscador por email //
  const [editUser, setEditUser] = useState(null); // modal de edición //
  const [isAuthorized, setIsAuthorized] = useState(false); // si el user es super_adm //
  const [checked, setChecked] = useState(false); // para esperar a chequear rol //

  // Verifico rol desde localStorage //
  useEffect(() => {
    const role = localStorage.getItem("role");
    console.log("Rol guardado:", role);
    if (role === "super_adm") {
      setIsAuthorized(true);
    }
    setChecked(true);
  }, []);

  // Cargo usuarios activos //
  const fetchUsers = async () => {
    try {
      const response = await userService.getAllActive();
      setUsers(response.data);
    } catch (error) {
      console.error("Error al traer usuarios:", error);
    }
  };

  // Cargo solicitudes pendientes //
  const fetchRequests = async () => {
    try {
      const response = await userService.getPending();
      setRequests(response.data);
    } catch (error) {
      console.error("Error al traer solicitudes:", error);
    }
  };

  // Solo traigo si es super_adm
  useEffect(() => {
    if (isAuthorized) {
      fetchRequests();
      fetchUsers();
    }
  }, [isAuthorized]);

  // Aprobar solicitud //
  const handleApprove = async (id) => {
    try {
      await userService.approve(id);
      fetchRequests();
      fetchUsers();
    } catch (err) {
      console.error("Error al aprobar usuario:", err.response?.data || err);
    }
  };

  // Rechazar solicitud //
  const handleReject = async (id) => {
    try {
      await userService.reject(id);
      fetchRequests();
    } catch (err) {
      console.error("Error al rechazar usuario:", err.response?.data || err);
    }
  };

  // Eliminar usuario activo //
  const handleDelete = async (id) => {
    try {
      await userService.delete(id);
      fetchUsers();
    } catch (err) {
      console.error("Error al eliminar usuario:", err.response?.data || err);
    }
  };

  // Filtro de búsqueda //
  const filteredUsers = users.filter((u) =>
    u.email?.toLowerCase().includes(search.toLowerCase())
  );

  if (!checked) return null;

  // Si no es super_adm muestro cartel de restricción //
  if (!isAuthorized) {
    return (
      <Container sx={{ mt: 5 }}>
        <Alert severity="error" sx={{ fontSize: "1.2rem", fontWeight: "bold" }}>
          🚫 Solo acceso a administradores (super_adm).
        </Alert>
      </Container>
    );
  }

  return (
    <Container className="user-container">
      {/* Botón volver atrás */}
      <Button
        startIcon={<ArrowBack />}
        className="btn-back"
        onClick={() => window.history.back()}
      >
        Volver
      </Button>

      <Typography variant="h4" className="user-title">
        Gestión de Usuarios
      </Typography>

      {/* Botones de pestañas */}
      <Box className="tab-menu">
        <Button
          className={activeTab === "requests" ? "tab-active" : "tab-btn"}
          onClick={() => setActiveTab("requests")}
        >
          Solicitudes Pendientes
        </Button>
        <Button
          className={activeTab === "users" ? "tab-active" : "tab-btn"}
          onClick={() => setActiveTab("users")}
        >
          Usuarios Activos
        </Button>
      </Box>

      {/* Solicitudes pendientes */}
      {activeTab === "requests" && (
        <TableContainer component={Paper} className="user-table-container">
          <Table>
            <TableHead>
              <TableRow className="user-table-header">
                <TableCell>ID</TableCell>
                <TableCell>Nombre</TableCell>
                <TableCell>Email</TableCell>
                <TableCell>Acciones</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {requests.map((req) => (
                <TableRow key={req.id} className="user-row">
                  <TableCell>{req.id}</TableCell>
                  <TableCell>{req.name}</TableCell>
                  <TableCell>{req.email}</TableCell>
                  <TableCell>
                    <IconButton className="btn-edit" onClick={() => handleApprove(req.id)}>
                      <CheckCircle />
                    </IconButton>
                    <IconButton className="btn-delete" onClick={() => handleReject(req.id)}>
                      <Cancel />
                    </IconButton>
                  </TableCell>
                </TableRow>
              ))}
              {requests.length === 0 && (
                <TableRow>
                  <TableCell colSpan={4}>No hay solicitudes pendientes</TableCell>
                </TableRow>
              )}
            </TableBody>
          </Table>
        </TableContainer>
      )}

      {activeTab === "users" && (
        <>
          <Box className="user-actions">
            <TextField
              label="Buscar por email"
              variant="outlined"
              size="small"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="user-search"
            />
          </Box>

          <TableContainer component={Paper} className="user-table-container">
            <Table>
              <TableHead>
                <TableRow className="user-table-header">
                  <TableCell>ID</TableCell>
                  <TableCell>Nombre</TableCell>
                  <TableCell>Email</TableCell>
                  <TableCell>Rol</TableCell>
                  <TableCell>Estado</TableCell>
                  <TableCell>Acciones</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {filteredUsers.map((user) => (
                  <TableRow key={user.id} className="user-row">
                    <TableCell>{user.id}</TableCell>
                    <TableCell>{user.name}</TableCell>
                    <TableCell>{user.email}</TableCell>
                    <TableCell>
                      {user.role === "super_adm"
                        ? "Super Admin"
                        : user.role === "admin"
                        ? "Administrador"
                        : "Visitante"}
                    </TableCell>
                    <TableCell>{user.is_active ? "Activo" : "Inactivo"}</TableCell>
                    <TableCell>
                      <IconButton className="btn-edit" onClick={() => setEditUser(user)}>
                        <Edit />
                      </IconButton>
                      <IconButton className="btn-delete" onClick={() => handleDelete(user.id)}>
                        <Delete />
                      </IconButton>
                    </TableCell>
                  </TableRow>
                ))}
                {filteredUsers.length === 0 && (
                  <TableRow>
                    <TableCell colSpan={6}>No hay usuarios activos</TableCell>
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </TableContainer>

          {editUser && (
            <UserEditModal
              user={editUser}
              onClose={() => setEditUser(null)}
              onSave={() => {
                setEditUser(null);
                fetchUsers();
              }}
            />
          )}
        </>
      )}
    </Container>
  );
}
