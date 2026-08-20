// ============================================================
// Posts de Instagram que se muestran en el Home
// ============================================================
// Para agregar un post nuevo:
//   1. Descargá la foto del post y guardala en:
//        React/src/assets/instagram/   (ej: post5.jpg)
//   2. Agregá un objeto nuevo acá abajo, apuntando a esa imagen:
//        {
//          image: "post5.jpg",
//          url: "https://www.instagram.com/bibliotecanovaroantonio/p/XXXX/",
//          caption: "Un texto corto opcional sobre el post",
//        }
//
// El "caption" es opcional: si lo dejás vacío (""), la tarjeta
// simplemente no muestra texto abajo de la foto.
//
// Máximo recomendado: 6 posts (para no sobrecargar el Home).
// ============================================================

const instagramPosts = [
  {
    image: "post1.jpg",
    url: "https://www.instagram.com/bibliotecanovaroantonio/p/DcH6kWwAWZ_/",
    caption: "",
  },
  {
    image: "post2.jpg",
    url: "https://www.instagram.com/bibliotecanovaroantonio/p/DVRF9mXjTkx/",
    caption: "",
  },
  {
    image: "post3.jpg",
    url: "https://www.instagram.com/bibliotecanovaroantonio/p/Db_-cfMjNkr/",
    caption: "",
  },
  {
    image: "post4.jpg",
    url: "https://www.instagram.com/p/DcPNenLgFNn/",
    caption: "",
  },
];

export default instagramPosts;