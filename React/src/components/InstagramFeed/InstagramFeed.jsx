import instagramPosts from "../../config/instagramPosts";
import "./InstagramFeed.css";

// Importa automáticamente TODAS las imágenes que haya dentro de
// src/assets/instagram/. Gracias a esto, cuando agreguen una imagen
// nueva (ej: post5.jpg) no hace falta tocar este archivo: alcanza
// con ponerla en la carpeta y sumar su entrada en instagramPosts.js.
const images = import.meta.glob(
  "../../assets/instagram/*.{jpg,jpeg,png,JPG,JPEG,PNG}",
  { eager: true, import: "default" }
);

function getImageUrl(filename) {
  const entry = Object.entries(images).find(([path]) =>
    path.endsWith(`/${filename}`)
  );
  return entry ? entry[1] : null;
}

const INSTAGRAM_PROFILE_URL = "https://www.instagram.com/bibliotecanovaroantonio/";

export default function InstagramFeed() {
  const posts = instagramPosts.slice(0, 6);

  if (posts.length === 0) return null;

  return (
    <section className="instagram-feed-section">
      <h2 className="section-title">Seguinos en Instagram</h2>

      <div className="instagram-feed-grid">
        {posts.map((post) => {
          const imgSrc = getImageUrl(post.image);

          return (
            <a
              key={post.url}
              href={post.url}
              target="_blank"
              rel="noopener noreferrer"
              className="instagram-card"
            >
              <div className="instagram-card-image-wrapper">
                {imgSrc ? (
                  <img
                    src={imgSrc}
                    alt={post.caption || "Publicación de Instagram de la biblioteca"}
                    className="instagram-card-image"
                  />
                ) : (
                  // Si el nombre del archivo en el config no coincide con
                  // ninguna imagen de la carpeta, avisamos en vez de romper.
                  <div className="instagram-card-missing">
                    Imagen no encontrada: {post.image}
                  </div>
                )}
                <span className="instagram-card-badge" aria-hidden="true">
                  📷
                </span>
              </div>

              {post.caption && (
                <p className="instagram-card-caption">{post.caption}</p>
              )}

              <span className="instagram-card-link">Ver en Instagram →</span>
            </a>
          );
        })}
      </div>

      <div className="see-all-instagram">
        <a href={INSTAGRAM_PROFILE_URL} target="_blank" rel="noopener noreferrer">
          Ver más en Instagram
        </a>
      </div>
    </section>
  );
}