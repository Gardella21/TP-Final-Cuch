
import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import "./ArticlePageDetail.css";

export const ArticlePageDetail = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [article, setArticle] = useState(null);
  const [loading, setLoading] = useState(true);

  const MINIO_URL = "http://172.24.224.1:9000/imagenes";
  /*const MINIO_URL = "http://localhost:9000/imagenes/";*/

  useEffect(() => {
    const fetchArticle = async () => {
      try {
        const response = await fetch(`http://localhost:9091/articles/${id}`);
        const data = await response.json();
        setArticle(data);
      } catch (error) {
        console.error("Error fetching article:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchArticle();
  }, [id]);

  if (loading) return <p>Cargando noticia...</p>;
  if (!article) return <p>Noticia no encontrada</p>;

  return( 
    <div className="article-detail-container">
     {/* Columna izquierda: título + descripción */}
      <div className="article-detail-text">
      <h1 className="article-detail-title">{article.title}</h1>
      <p className="article-detail-body">{article.body}</p>
   </div>

    {/* Columna derecha: imagen + fecha + botón */}
    <div className="article-detail-side">
      {article.image && (
        <img
          src={article.image}
          alt={article.title}
          className="article-detail-image"
      />
    )}
    <small className="article-detail-date">📅 {article.date}</small>
      <button className="read-more-btn" onClick={() => navigate("/noticias")}>
      ← Volver a noticias
      </button>
   </div>
  </div>
);
};
