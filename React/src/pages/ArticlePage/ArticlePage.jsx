import { useEffect, useState } from "react";
import {
  Box,
  Card,
  CardContent,
  CardMedia,
  Container,
  Typography,
} from "@mui/material";
import { Link } from "react-router-dom";
import { articleService } from "../../services/articleService";
import "./ArticlePage.css";

export const ArticlePage = () => {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchArticles = async () => {
      try {
        const response = await articleService.getAllArticles();
        setArticles(response.data);
      } catch (error) {
        console.error("Error fetching articles:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchArticles();
  }, []);

  return (
    <Box sx={{ minHeight: "100vh", display: "flex", flexDirection: "column" }}>
      <Container className="articles-container" maxWidth={false} disableGutters>
        <Box sx={{ flexGrow: 1 }}>
          {loading ? (
            <Box display="flex" justifyContent="center" mt={5}>
              <Typography variant="h6" className="loading-text">
                Cargando...
              </Typography>
            </Box>
          ) : articles.length === 0 ? (
            <Typography variant="h6" align="center" mt={5}>
              No hay artículos disponibles.
            </Typography>
          ) : (
            <Box className="articles-grid">
              {articles.map((article) => {
                const dateStr = article.date || article.createdAt || null;
                const formattedDate = dateStr
                  ? new Date(dateStr).toLocaleDateString("es-AR", {
                      year: "numeric",
                      month: "short",
                      day: "numeric",
                    })
                  : null;

                return (
                  <Link
                    to={`/articles/${article.id || article._id}`}
                    className="article-link"
                    key={article._id ?? article.id}
                  >
                    <Card className="article-card">
                      {article.image ? (
                        <CardMedia
                          component="img"
                          image={article.image}
                          alt={article.title}
                          className="article-image"
                        />
                      ) : (
                        <div className="article-image--placeholder">Sin imagen</div>
                      )}

                      <CardContent>
                        <Typography variant="h6" gutterBottom textAlign="center">
                          {article.title}
                        </Typography>

                        {formattedDate && (
                          <Typography
                            variant="caption"
                            display="block"
                            className="article-date"
                            textAlign="center"
                          >
                            {formattedDate}
                          </Typography>
                        )}

                        {article.summary && (
                          <Typography
                            variant="body2"
                            className="article-summary"
                            mt={1}
                          >
                            {article.summary}
                          </Typography>
                        )}
                      </CardContent>
                    </Card>
                  </Link>
                );
              })}
            </Box>
          )}
        </Box>
      </Container>
    </Box>
  );
};
