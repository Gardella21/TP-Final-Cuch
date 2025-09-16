
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import "./ArticlePage.css"; 

export const ArticlePage = () => {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);

  const MINIO_URL = "http://localhost:9000/imagenes/";

  useEffect(() => {
    const fetchArticles = async () => {
      try {
        const response = await fetch("http://localhost:9091/articles");
        const data = await response.json();
        setArticles(data);
      } catch (error) {
        console.error("Error fetching articles:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchArticles();
  }, []);

  if (loading) return <p>Cargando artículos...</p>;

  if (articles.length === 0) return <p>No hay artículos disponibles.</p>;

  return (
    <div className="articles-container">
      <div className="articles-grid">
        {articles.map((article) => (
          <div key={article.id} className="article-card">
            <h3>{article.title}</h3>
            {article.image && (
              <img
                src={`${MINIO_URL}${article.image}`}
                alt={article.title}
                className="article-image"
              />
            )}
            <p>{article.body.substring(0, 100)}...</p> 
            <small>{article.date}</small>
            <Link to={`/articles/${article.id}`} className="read-more-btn">
              Leer más
            </Link>
          </div>
        ))}
      </div>
    </div>
  );
};