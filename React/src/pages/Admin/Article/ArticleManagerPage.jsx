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


export function ArticleManagerPage() {
    const navigate = useNavigate();
    const [noticias, setNoticias] = useState([]);
    const [loading, setLoading] = useState(true);


    // Traer datos desde la api
    useEffect(() => {
        fetch("http://localhost:9091/articles")
        .then((res) => res.json())
        .then((data) => {
        setNoticias(data);
        setLoading(false);
        })
        .catch(() => setLoading(false));
    }, []);


    const handleCrear = () => {
        navigate("/admin/article-new");
    };


    const handleEditar = (id) => {
        alert(`Editar noticia con id: ${id}`);
    };


    const handleEliminar = (id) => {
        if (window.confirm("¿Seguro que deseas eliminar esta noticia?")) {
            // Aquí iría el fetch DELETE a la API
            setNoticias(noticias.filter((n) => n.id !== id));
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