import { useEffect, useState } from "react";
import {
  Box,
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
  CircularProgress,
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  TextField
} from "@mui/material";
import { Edit, Delete } from "@mui/icons-material";
import { useNavigate } from "react-router";
import { articleService } from "../../../services/articleService";
import "./ArticleManagerPage.css";

export function ArticleManagerPage() {
  const navigate = useNavigate();
  const [noticias, setNoticias] = useState([]);
  const [loading, setLoading] = useState(true);
  const [openModal, setOpenModal] = useState(false); // Controla si el modal está abierto o no
  const [currentArticle, setCurrentArticle] = useState(null); // Guarda los datos del artículo a editar

  // Traer datos desde la api
  useEffect(() => {
    articleService.getAllArticles()
      .then(response => {
        setNoticias(response.data);
        setLoading(false);
      })
      .catch(() => setLoading(false));
  }, []); // Esto se ejecuta una vez al cargar el componente

  // Abrir el modal de edición
  const handleEditar = (id) => {
    const articulo = noticias.find(noticia => noticia.id === id);
    setCurrentArticle(articulo);
    setOpenModal(true);
  };

  // Cerrar el modal de edición
  const handleCloseModal = () => {
    setOpenModal(false);
    setCurrentArticle(null);
  };

  // Guardar cambios del artículo
  const handleSaveChanges = () => {
    articleService.updateArticle(currentArticle.id, currentArticle)
      .then(response => {
        setNoticias(noticias.map(noticia =>
          noticia.id === currentArticle.id ? currentArticle : noticia
        ));
        handleCloseModal();
      })
      .catch(err => {
        alert("Error al guardar los cambios");
        console.error(err);
      });
  };

  // Eliminar artículo
  const handleEliminar = (id) => {
    if (window.confirm("¿Seguro que deseas eliminar esta noticia?")) {
      articleService.deleteArticleById(id)
        .then(() => {
          setNoticias(noticias.filter(noticia => noticia.id !== id));
        })
        .catch(err => {
          alert("Error al eliminar la noticia");
          console.error(err);
        });
    }
  };

  const handleCrear = () => {
    navigate("/admin/article-new");
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setCurrentArticle({
      ...currentArticle,
      [name]: value
    });
  };

  return (
    <div className="article-manager-bg">
      <Container className="container">
        <div className="header">
          <Typography variant="h4">Administración de Noticias</Typography>
          <Button
            className="create-button"
            onClick={handleCrear}
            variant="contained"
          >
            + Nueva Noticia
          </Button>
        </div>

        {loading ? (
          <div className="loading">
            <CircularProgress />
          </div>
        ) : (
          <TableContainer component={Paper} className="table-container">
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell><b>ID</b></TableCell>
                  <TableCell><b>Título</b></TableCell>
                  <TableCell><b>Fecha</b></TableCell>
                  <TableCell align="right"><b>Acciones</b></TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {noticias.map((noticia) => (
                  <TableRow key={noticia.id}>
                    <TableCell>{noticia.id}</TableCell>
                    <TableCell>{noticia.title}</TableCell>
                    <TableCell>{noticia.date}</TableCell>
                    <TableCell align="right">
                      <IconButton color="primary" onClick={() => handleEditar(noticia.id)}>
                        <Edit />
                      </IconButton>
                      <IconButton color="error" onClick={() => handleEliminar(noticia.id)}>
                        <Delete />
                      </IconButton>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </TableContainer>
        )}

        {/* Modal para editar artículo */}
        <Dialog open={openModal} onClose={handleCloseModal}>
          <DialogTitle>Editar Noticia</DialogTitle>
          <DialogContent>
            {currentArticle && (
              <>
                <TextField
                  label="Título"
                  variant="outlined"
                  fullWidth
                  name="title"
                  value={currentArticle.title}
                  onChange={handleChange}
                  margin="normal"
                />
                <TextField
                  label="Fecha"
                  variant="outlined"
                  fullWidth
                  name="date"
                  value={currentArticle.date}
                  onChange={handleChange}
                  margin="normal"
                />
                <TextField
                  label="Contenido"
                  variant="outlined"
                  fullWidth
                  name="content"
                  value={currentArticle.content}
                  onChange={handleChange}
                  margin="normal"
                  multiline
                  rows={4}
                />
              </>
            )}
          </DialogContent>
          <DialogActions>
            <Button onClick={handleCloseModal} color="secondary">Cancelar</Button>
            <Button onClick={handleSaveChanges} color="primary">Guardar Cambios</Button>
          </DialogActions>
        </Dialog>
      </Container>
    </div>
  );
}
