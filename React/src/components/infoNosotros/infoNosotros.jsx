import React from "react";
import "./InfoNosotros.css";

const InfoNosotros = () => {
  return (
    <div className="info-page">
      <section className="info-section">
        <h1>📚 Sobre Nosotros</h1>
        <p>
          La Biblioteca Municipal fue fundada en 1950 con el objetivo de fomentar la lectura y la cultura en la comunidad.  
          A lo largo de los años, se ha convertido en un espacio de encuentro, aprendizaje y acceso a la información para todas las edades.
        </p>
      </section>

      <section className="info-section">
        <h2>📖 Nuestra Historia</h2>
        <p>
          Iniciamos con una pequeña colección de 500 libros donados por vecinos.  
          Hoy contamos con más de 20,000 ejemplares, salas de lectura, talleres, cursos y actividades culturales.
        </p>
      </section>

      <section className="info-section">
        <h2>📩 Contacto</h2>
        <p><strong>Dirección:</strong>{""}  
         <a href="https://www.google.com/maps/search/?api=1&query=Moreno+30+Chivilcoy+Buenos+Aires" 
         target="_blank" 
         rel="noopener noreferrer">Moreno 30, Chivilcoy, Buenos Aires</a> </p>
        <p><strong>Teléfono:</strong> (2346)432493.</p>
        <p><strong>Email: </strong><a href="mailto:contacto@biblioteca.com"> contacto@biblioteca.com</a></p>
        <p><strong>Mail de reclamos: </strong><a href="mailto:reclamos@bibloteca.com"> reclamos@bibloteca.com</a></p>
      </section>

      <section className="info-section">
        <h2>❓ Preguntas Frecuentes</h2>
        <ul>
          <li><strong>¿Cómo me hago socio?</strong> Presentándote con tu DNI y planilla de inscripcion.</li>
          <li><strong>¿La inscripción tiene costo?</strong> podes acceder gratis a los libros y salas, solo abonando coperadora podes retirara los libros y material que necesites.</li>
          <li><strong>¿Cuánto tiempo puedo tener un libro?</strong> El préstamo es de 15 días con posibilidad de renovación.</li>
          <li><strong>¿Hay actividades para niños?</strong> Sí, tenemos talleres para niños, adocesentes y adultos.</li>
        </ul>
      </section>
    </div>
  );
};

export default InfoNosotros;
