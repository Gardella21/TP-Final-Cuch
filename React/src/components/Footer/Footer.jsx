import React from "react";
import "./Footer.css";

const Footer = () => {
  return (
    <footer className="library-footer">
      <div className="footer-container">
        <h3>BIBLIOTECA POPULAR Dr. Antonio Novaro</h3>

        <div className="footer-info">
          <p>
            <span className="icon">📍</span>
            <a
              href="https://www.google.com/maps/search/?api=1&query=Moreno+30+Chivilcoy+Buenos+Aires"
              target="_blank"
              rel="noopener noreferrer"
            >
              Moreno 30, Chivilcoy
            </a>
          </p>

          <p>
            <span className="icon">☎️</span>
            <a href="tel:+542346432493">(2346) 432493</a>
          </p>

          <p>
            <span className="icon">✉️</span>
            <a
              href="mailto:bibliotecanovarro@hotmail.com"
              onClick={(e) => {
                e.preventDefault();
                window.open(
                  "https://mail.google.com/mail/?view=cm&fs=1&to=bibliotecanovarro@hotmail.com&su=Consulta%20desde%20la%20web",
                  "_blank"
                );
              }}
            >
              bibliotecanovarro@hotmail.com
            </a>
          </p>

          <p>
            <span className="icon">📸</span>
            <a
              href="https://www.instagram.com/bibliotecanovaroantonio"
              target="_blank"
              rel="noopener noreferrer"
            >
              Instagram
            </a>{" "}
            |{" "}
            <a
              href="https://www.facebook.com/100064143998729"
              target="_blank"
              rel="noopener noreferrer"
            >
              Facebook
            </a>
          </p>

          <p>
            <span className="icon">🕒</span>
            Lunes a Viernes de 8:00 a 19:00 · Sábados de 9:00 a 13:00
          </p>
        </div>

        <p className="footer-copy">
          © 2025 Biblioteca Popular Dr. Antonio Novaro — Chivilcoy, Buenos Aires
        </p>
      </div>
    </footer>
  );
};

export default Footer;
