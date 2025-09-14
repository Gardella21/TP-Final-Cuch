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
CircularProgress
} from "@mui/material";
import { Edit, Delete } from "@mui/icons-material";
import "./ArticleManagerPage.css";
import { useNavigate } from "react-router";
import { articleService } from "../../../services/articleService";


export function ArticleManagerPage() {
    const navigate = useNavigate();
    const [noticias, setNoticias] = useState([]);
    const [loading, setLoading] = useState(true);


    // Traer datos desde la api
    articleService.getAllArticles()
    .then(response => {
        setNoticias(response.data); 
        setLoading(false);
    })
    .catch(() => setLoading(false));


    const handleCrear = () => {
        navigate("/admin/article-new");
    };


    const handleEditar = (id) => {
        alert(`Editar noticia con id: ${id}`);
    };


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
        </Container>
    </div>
  );
}