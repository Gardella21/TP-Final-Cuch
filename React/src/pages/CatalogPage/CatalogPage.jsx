// CAMBIOS respecto al CatalogPage original:
// 1. Se importa BookReservationModal
// 2. Se agrega estado selectedBook y modalOpen
// 3. Se agrega columna "Reservar" en la tabla con botón por libro
// 4. Se renderiza el modal al final del componente

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
  Button,        // NUEVO
} from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import { bookService } from "../../services/bookService";
import { BookReservationModal } from "../../components/BookReservationModal/BookReservationModal"; // NUEVO

const CACHE_KEY = "librosGuardados";

const readCache = () => {
  try {
    const raw = localStorage.getItem(CACHE_KEY);
    if (!raw) return null;
    return JSON.parse(raw);
  } catch {
    return null;
  }
};

const writeCache = (books) => {
  try {
    localStorage.setItem(CACHE_KEY, JSON.stringify(books));
  } catch {}
};

export function CatalogPage() {
  const [books, setBooks] = useState([]);
  const [q, setQ] = useState("");
  const [author, setAuthor] = useState("");
  const [category, setCategory] = useState("");
  const [onlyAvailable, setOnlyAvailable] = useState(false);
  const [onlyReserved, setOnlyReserved] = useState(false);

  // NUEVO: estado para el modal de reserva
  const [selectedBook, setSelectedBook] = useState(null);
  const [modalOpen, setModalOpen] = useState(false);

  useEffect(() => {
    const fetchBooks = async () => {
      const cached = readCache();
      if (cached && cached.length > 0) {
        setBooks(cached);
        return;
      }
      try {
        const { data } = await bookService.search({});
        if (Array.isArray(data)) {
          setBooks(data);
          writeCache(data);
        }
      } catch (error) {
        console.error("Error cargando libros:", error);
      }
    };
    fetchBooks();
  }, []);

  const filteredBooks = books.filter((book) => {
    const matchesTitle = book.titulo?.toLowerCase().includes(q.toLowerCase());
    const matchesAuthor = author
      ? book.autor?.toLowerCase().includes(author.toLowerCase())
      : true;
    const matchesCategory = category
      ? book.materia?.toLowerCase().includes(category.toLowerCase())
      : true;
    const matchesAvailable = onlyAvailable ? book.disponibilidad : true;
    const matchesReserved = onlyReserved ? book.reservada : true;

    return (
      matchesTitle &&
      matchesAuthor &&
      matchesCategory &&
      matchesAvailable &&
      matchesReserved
    );
  });

  // NUEVO: abre el modal con el libro seleccionado
  const handleOpenReservation = (book) => {
    setSelectedBook(book);
    setModalOpen(true);
  };

  return (
    <div className="catalog-background">
      <Container maxWidth="lg" className="catalog">
        <Typography variant="h2" className="catalog-title">
          Catálogo
        </Typography>

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
                <TableCell>Reservar</TableCell>{/* NUEVO */}
              </TableRow>
            </TableHead>
            <TableBody>
              {filteredBooks.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={9} align="center">
                    No se encontraron resultados
                  </TableCell>
                </TableRow>
              ) : (
                filteredBooks.map((book) => (
                  <TableRow key={book.id}>
                    <TableCell>{book.codigo}</TableCell>
                    <TableCell>{book.titulo}</TableCell>
                    <TableCell>{book.autor}</TableCell>
                    <TableCell>{book.materia}</TableCell>
                    <TableCell>{book.editorial}</TableCell>
                    <TableCell>{book.anio}</TableCell>
                    <TableCell
                      className={
                        book.disponibilidad
                          ? "status-available"
                          : "status-unavailable"
                      }
                    >
                      {book.disponibilidad ? "Disponible" : "No disponible"}
                    </TableCell>
                    <TableCell
                      className={
                        book.reservada
                          ? "status-reserved"
                          : "status-not-reserved"
                      }
                    >
                      {book.reservada ? "Reservada" : "No reservada"}
                    </TableCell>

                    {/* NUEVO: botón de reserva — solo si el libro está disponible */}
                    <TableCell>
                      <Button
                        variant="contained"
                        size="small"
                        disabled={!book.disponibilidad}
                        onClick={() => handleOpenReservation(book)}
                      >
                        {book.disponibilidad ? "Reservar" : "No disponible"}
                      </Button>
                    </TableCell>
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </TableContainer>
      </Container>

      {/* NUEVO: modal de reserva */}
      <BookReservationModal
        open={modalOpen}
        onClose={() => setModalOpen(false)}
        book={selectedBook}
      />
    </div>
  );
}
