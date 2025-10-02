import {
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  Button,
  TextField,
  MenuItem,
  Box,
} from "@mui/material";
import { useState } from "react";
import { userService } from "../../../services/userService";
import "./UserEditModal.css";

export default function UserEditModal({ user, onClose, onSave }) {
  const [role, setRole] = useState(user.role); // rol(admin, visitor, super_adm)//
  const [isActive, setIsActive] = useState(user.is_active); 

  // Guardar cambios
  const handleSave = async () => {
    try {
      const payload = {
        id: user.id,
        role, 
        is_active: isActive, 
      };

      console.log("Actualizando usuario:", payload);

      await userService.update(payload);
      onSave();
    } catch (err) {
      console.error("Error al actualizar usuario:", err.response?.data || err);
    }
  };

  return (
    <Dialog open={!!user} onClose={onClose}>
      <DialogTitle className="modal-title">Editar Usuario</DialogTitle>
      <DialogContent>
        <Box className="modal-content">
          <TextField
            label="Email"
            fullWidth
            margin="dense"
            value={user.email}
            disabled
          />
          <TextField
            select
            label="Rol"
            fullWidth
            margin="dense"
            value={role}
            onChange={(e) => setRole(e.target.value)}
          >
            <MenuItem value="super_adm">Super Admin</MenuItem>
            <MenuItem value="admin">Administrador</MenuItem>
            <MenuItem value="visitor">Visitante</MenuItem>
          </TextField>
          <TextField
            select
            label="Estado"
            fullWidth
            margin="dense"
            value={isActive ? "true" : "false"}
            onChange={(e) => setIsActive(e.target.value === "true")}
          >
            <MenuItem value="true">Activo</MenuItem>
            <MenuItem value="false">Inactivo</MenuItem>
          </TextField>
        </Box>
      </DialogContent>
      <DialogActions>
        <Button onClick={onClose} className="btn-cancel">
          Cancelar
        </Button>
        <Button onClick={handleSave} className="btn-save">
          Guardar
        </Button>
      </DialogActions>
    </Dialog>
  );
}
