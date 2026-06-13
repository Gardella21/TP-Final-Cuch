import { useState } from "react";
import {
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  TextField,
  Button,
  Typography,
  Alert,
  CircularProgress,
  Box,
} from "@mui/material";
import { bookReservationService } from "../../services/bookReservationService";

export function BookReservationModal({ open, onClose, book }) {
  const [form, setForm] = useState({
    name: "",
    surname: "",
    email: "",
    phone: "",
  });
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState("");

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
    setError("");
  };

  const handleClose = () => {
    setForm({ name: "", surname: "", email: "", phone: "" });
    setSuccess(false);
    setError("");
    onClose();
  };

  const handleSubmit = async () => {
    const { name, surname, email, phone } = form;

    if (!name || !surname || !email || !phone) {
      setError("Por favor completá todos los campos obligatorios.");
      return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      setError("El correo electrónico no es válido.");
      return;
    }

    setLoading(true);
    try {
      await bookReservationService.create({
        name,
        surname,
        email,
        phone: parseInt(phone),
        id_book: book.id,
      });
      setSuccess(true);
    } catch (err) {
      setError(err.message || "Ocurrió un error al enviar la reserva.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <Dialog open={open} onClose={handleClose} maxWidth="sm" fullWidth>
      <DialogTitle>Reservar libro</DialogTitle>
      <DialogContent>
        {success ? (
          <Box textAlign="center" py={3}>
            <Alert severity="success" sx={{ mb: 2 }}>
              ¡Reserva enviada! Un bibliotecario se contactará con vos para
              confirmarla.
            </Alert>
            <Typography variant="body2" color="text.secondary">
              Libro: <strong>{book?.titulo}</strong> — Código:{" "}
              <strong>{book?.codigo}</strong>
            </Typography>
          </Box>
        ) : (
          <>
            <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
              Estás reservando: <strong>{book?.titulo}</strong> (
              {book?.codigo})
            </Typography>

            {error && (
              <Alert severity="error" sx={{ mb: 2 }}>
                {error}
              </Alert>
            )}

            <TextField
              label="Nombre *"
              name="name"
              fullWidth
              margin="dense"
              value={form.name}
              onChange={handleChange}
            />
            <TextField
              label="Apellido *"
              name="surname"
              fullWidth
              margin="dense"
              value={form.surname}
              onChange={handleChange}
            />
            <TextField
              label="Email *"
              name="email"
              type="email"
              fullWidth
              margin="dense"
              value={form.email}
              onChange={handleChange}
            />
            <TextField
              label="Teléfono *"
              name="phone"
              type="number"
              fullWidth
              margin="dense"
              value={form.phone}
              onChange={handleChange}
            />
          </>
        )}
      </DialogContent>
      <DialogActions>
        {success ? (
          <Button onClick={handleClose} variant="contained">
            Cerrar
          </Button>
        ) : (
          <>
            <Button onClick={handleClose} disabled={loading}>
              Cancelar
            </Button>
            <Button
              onClick={handleSubmit}
              variant="contained"
              disabled={loading}
              startIcon={loading ? <CircularProgress size={16} /> : null}
            >
              {loading ? "Enviando..." : "Confirmar reserva"}
            </Button>
          </>
        )}
      </DialogActions>
    </Dialog>
  );
}
