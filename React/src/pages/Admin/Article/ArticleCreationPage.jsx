import { useState } from "react";
import {
  Box,
  Button,
  Container,
  Paper,
  TextField,
  Typography,
} from "@mui/material";
import "./ArticleCreationPage.css";
import { useNavigate } from "react-router";

export function ArticleCreationPage() {
  const [titulo, setTitulo] = useState("");
  const [contenido, setContenido] = useState("");
  const [imagen, setImagen] = useState(null);
  const [preview, setPreview] = useState(null);

  const navigate = useNavigate();

  const handleImagen = (e) => {
    const file = e.target.files[0];
    if (file) {
      setImagen(file);
      setPreview(URL.createObjectURL(file));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("titulo", titulo);
    formData.append("contenido", contenido);
    formData.append("imagen", imagen);

    fetch("http://localhost:9091/noticias", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then(() => {
        navigate("/noticias"); // volver al listado
      })
      .catch((err) => console.error("Error creando noticia", err));
  };

  return (
    <div className="article-creator-bg">
        <Container maxWidth="md" className="crear-container">
            <Box className="header-crear">
            <Button
                variant="contained"
                color="primary"
                className="volver-btn"
                onClick={() => navigate(-1)}
            >
                ← Volver
            </Button>
            <Typography variant="h4" className="titulo-pagina">
                Crear Nueva Noticia
            </Typography>
            </Box>

            <form onSubmit={handleSubmit}>
            <Paper className="preview-card">
                <Box className="preview-contenido">
                <TextField
                    variant="outlined"
                    placeholder="Título de la noticia"
                    value={titulo}
                    onChange={(e) => setTitulo(e.target.value)}
                    fullWidth
                    className="campo-titulo"
                />

                <TextField
                    variant="outlined"
                    placeholder="Contenido de la noticia..."
                    value={contenido}
                    onChange={(e) => setContenido(e.target.value)}
                    fullWidth
                    multiline
                    rows={6}
                    className="campo-contenido"
                />
                </Box>

                {/* Imagen abajo */}
                <Box className="preview-imagen">
                {preview ? (
                    <img src={preview} alt="Vista previa" />
                ) : (
                    <div className="preview-placeholder">
                    <Typography variant="body2" color="text.secondary">
                        Vista previa de la imagen
                    </Typography>
                    </div>
                )}
                <Button
                    variant="outlined"
                    component="label"
                    className="btn-subir"
                >
                    Subir Imagen
                    <input
                    type="file"
                    hidden
                    accept="image/*"
                    onChange={handleImagen}
                    />
                </Button>
                </Box>
            </Paper>

            <Box textAlign="center" mt={3}>
                <Button
                type="submit"
                variant="contained"
                color="primary"
                size="large"
                >
                Crear Noticia
                </Button>
            </Box>
            </form>
      </Container>
    </div>
  );
}
