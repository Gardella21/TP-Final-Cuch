
import "./CatalogPage.css";
import React, { useEffect, useMemo, useState } from "react";
import {
  Box,
  Container,
  Typography,
  TextField,
  InputAdornment,
  Grid,
  FormControlLabel,
  Checkbox,
  MenuItem,
  CircularProgress,
} from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import { bookService } from "../../services/bookservice";



function useDebounce(value, delay = 350) {
  const [debounced, setDebounced] = useState(value);
  useEffect(() => {
    const t = setTimeout(() => setDebounced(value), delay);
    return () => clearTimeout(t);
  }, [value, delay]);
  return debounced;
}

export function CatalogPage() {
 
  const [books, setBooks] = useState([]);
  const [loading, setLoading] = useState(false);
  const [errorMsg, setErrorMsg] = useState("");

 
  const [q, setQ] = useState("");
  const [author, setAuthor] = useState("");
  const [category, setCategory] = useState("");
  const [onlyAvailable, setOnlyAvailable] = useState(false);
  const [onlyReserved, setOnlyReserved] = useState(false);

 
  const dq = useDebounce(q);
  const dAuthor = useDebounce(author);
  const dCategory = useDebounce(category);
  const dOnlyAvailable = useDebounce(onlyAvailable);
  const dOnlyReserved = useDebounce(onlyReserved);

 
  useEffect(() => {
    const fetchBooks = async () => {
      setLoading(true);
      setErrorMsg("");

     
      const disponible = dOnlyAvailable ? true : null;
      const reservada = dOnlyReserved ? true : null;

      try {
        const { data } = await bookService.search({
          titulo: dq,
          autor: dAuthor,
          materia: dCategory, 
          editorial: "",
          anio: null,
          disponible,
          reservada,
        });
        setBooks(Array.isArray(data) ? data : []);
      } catch (err) {
        setErrorMsg(err?.message || "Error al cargar el catálogo");
        setBooks([]);
      } finally {
        setLoading(false);
      }
    };

    fetchBooks();
  }, [dq, dAuthor, dCategory, dOnlyAvailable, dOnlyReserved]);

  
  const authors = useMemo(
    () => Array.from(new Set(books.map((b) => b.autor).filter(Boolean))).sort(),
    [books]
  );
  const categories = useMemo(
    () => Array.from(new Set(books.map((b) => b.materia).filter(Boolean))).sort(),
    [books]
  );

  return (
    <div className="catalog-background">
      <Container maxWidth="lg" className="catalog">
        <Typography variant="h2" className="catalog-title">
          Catálogo
        </Typography>

        {/* Buscador */}
        <TextField
          className="catalog-search"
          fullWidth
          placeholder="Buscar por título…"
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
            {/* Autor */}
            <Grid item xs={12} md={4}>
              <div className="field-label">Autor</div>
              <TextField
                className="select-field"
                select
                fullWidth
                variant="outlined"
                value={author}
                onChange={(e) => setAuthor(e.target.value)}
                SelectProps={{ displayEmpty: true }}
              >
                <MenuItem value="">
                  <span className="select-placeholder">Todos los autores</span>
                </MenuItem>
                {authors.map((a) => (
                  <MenuItem key={a} value={a}>
                    {a}
                  </MenuItem>
                ))}
              </TextField>
            </Grid>

            {/* Categoría (materia) */}
            <Grid item xs={12} md={4}>
              <div className="field-label">Categoría</div>
              <TextField
                className="select-field"
                select
                fullWidth
                variant="outlined"
                value={category}
                onChange={(e) => setCategory(e.target.value)}
                SelectProps={{ displayEmpty: true }}
              >
                <MenuItem value="">
                  <span className="select-placeholder">Todas las categorías</span>
                </MenuItem>
                {categories.map((c) => (
                  <MenuItem key={c} value={c}>
                    {c}
                  </MenuItem>
                ))}
              </TextField>
            </Grid>

            {/* Checks */}
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
                label="Colección reservada"
              />
            </Grid>
          </Grid>
        </Box>

        {/* Estados */}
        {loading && (
          <Box style={{ display: "flex", justifyContent: "center", marginTop: 16 }}>
            <CircularProgress />
          </Box>
        )}

        {!loading && errorMsg && (
          <div className="no-results">{errorMsg}</div>
        )}

        {/* Resultados */}
        {!loading && !errorMsg && (
          <>
            {books.length === 0 ? (
              <div className="no-results">No se encontraron resultados.</div>
            ) : (
              <Grid container spacing={2}>
                {books.map((b) => (
                  <Grid item xs={12} md={6} lg={4} key={b.id}>
                    <Box className="book-card" padding={2}>
                      <Typography className="book-title">{b.titulo}</Typography>
                      <Typography>
                        {b.autor || "Autor desconocido"} · {b.materia || "Sin categoría"}
                      </Typography>
                      <Typography>
                        {b.editorial ? `Editorial: ${b.editorial}` : ""}
                        {b.edicion ? ` · Edición: ${b.edicion}` : ""}
                        {b.anio ? ` · Año: ${b.anio}` : ""}
                      </Typography>
                      <Typography className={b.disponibilidad ? "status-available" : "status-unavailable"}>
                        {b.disponibilidad ? "Disponible" : "No disponible"}
                        {b.reservada ? " · Reservada" : ""}
                      </Typography>
                    </Box>
                  </Grid>
                ))}
              </Grid>
            )}
          </>
        )}
      </Container>
    </div>
  );
}
