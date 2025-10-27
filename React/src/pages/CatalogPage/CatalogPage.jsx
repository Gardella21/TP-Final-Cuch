import "./CatalogPage.css";
import { useEffect, useState } from "react";
import {
  Box,
  Container,
  Typography,
  TextField,
  InputAdornment,
  Grid,
  FormControlLabel,
  Checkbox,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
} from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import { bookService } from "../../services/bookService";

export function CatalogPage() {
  const [books, setBooks] = useState([]);
  const [q, setQ] = useState("");
  const [author, setAuthor] = useState("");
  const [category, setCategory] = useState("");
  const [onlyAvailable, setOnlyAvailable] = useState(false);
  const [onlyReserved, setOnlyReserved] = useState(false);

  useEffect(() => {
    const fetchBooks = async () => {
      try {
        const { data } = await bookService.search({
          titulo: q,
          autor: author,
          materia: category,
          disponible: onlyAvailable ? 1 : null,
          reservada: onlyReserved ? 1 : null,
        });
        setBooks(data);
      } catch (error) {
        console.error("Error cargando libros:", error);
      }
    };
    fetchBooks();
  }, [q, author, category, onlyAvailable, onlyReserved]);

  return (
    <div className="catalog-background">
      <Container maxWidth="lg" className="catalog">
        <Typography variant="h2" className="catalog-title">
          Catálogo
        </Typography>

        {/* Buscador por título */}
        <TextField
          className="catalog-search"
          fullWidth
          placeholder="Buscar por título..."
          variant="outlined"
          value={q}
          onChange={(e) => setQ(e.target.value)}
          InputProps={{
            startAdornment: (
              <InputAdornment position="start">
                <SearchIcon />
              </InputAdornment>
            ),
          }}
        />

        {/* Filtros */}
        <Box className="filters-card">
          <Grid container spacing={2} alignItems="center">
            <Grid item xs={12} md={4}>
              <div className="field-label">Autor</div>
              <TextField
                className="select-field"
                variant="outlined"
                value={author}
                onChange={(e) => setAuthor(e.target.value)}
                placeholder="Buscar por autor..."
                fullWidth
              />
            </Grid>

            <Grid item xs={12} md={4}>
              <div className="field-label">Materia</div>
              <TextField
                className="select-field"
                variant="outlined"
                value={category}
                onChange={(e) => setCategory(e.target.value)}
                placeholder="Buscar por materia..."
                fullWidth
              />
            </Grid>

            <Grid item xs={12} md={4} className="filters-checks">
              <FormControlLabel
                control={
                  <Checkbox
                    checked={onlyAvailable}
                    onChange={(e) => setOnlyAvailable(e.target.checked)}
                  />
                }
                label="Solo disponibles"
              />
              <FormControlLabel
                control={
                  <Checkbox
                    checked={onlyReserved}
                    onChange={(e) => setOnlyReserved(e.target.checked)}
                  />
                }
                label="Solo reservados"
              />
            </Grid>
          </Grid>
        </Box>

        {/* Resultados en tabla */}
        <TableContainer component={Paper} className="catalog-table">
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>Código</TableCell>
                <TableCell>Título</TableCell>
                <TableCell>Autor</TableCell>
                <TableCell>Materia</TableCell> 
                <TableCell>Editorial</TableCell>
                <TableCell>Año</TableCell>
                <TableCell>Disponibilidad</TableCell>
                <TableCell>Colección Reservada</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {books.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={8} align="center">
                    No se encontraron resultados
                  </TableCell>
                </TableRow>
              ) : (
                books.map((book) => (
                  <TableRow key={book.id}>
                    <TableCell>{book.codigo}</TableCell>
                    <TableCell>{book.titulo}</TableCell>
                    <TableCell>{book.autor}</TableCell>
                    <TableCell>{book.materia}</TableCell> 
                    <TableCell>{book.editorial}</TableCell>
                    <TableCell>{book.anio}</TableCell>

                    {/* Disponible con color */}
                    <TableCell
                      className={
                        book.disponibilidad
                          ? "status-available"
                          : "status-unavailable"
                      }
                    >
                      {book.disponibilidad ? "Disponible" : "No disponible"}
                    </TableCell>

                    {/* Reservada con color */}
                    <TableCell
                      className={
                        book.reservada ? "status-reserved" : "status-not-reserved"
                      }
                    >
                      {book.reservada ? "Reservada" : "No reservada"}
                    </TableCell>
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </TableContainer>
      </Container>
    </div>
  );
}
