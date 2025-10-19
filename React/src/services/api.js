// src/services/api.js
import axios from "axios";

const API_BASE_URL = "http://localhost:9091";

export const api = axios.create({
  baseURL: API_BASE_URL,
});

// Interceptar las solicitudes //
api.interceptors.request.use((config) => {
  // Si existe un token, lo incluye en los encabezados //
  const token = localStorage.getItem("token");

  // 🔐 Aseguramos que el token no sea "null"/"undefined" string
  const hasToken = token && token !== "null" && token !== "undefined";

  if (hasToken) {
    // Compatibilidad total: enviamos ambas variantes por si el backend es sensible al casing
    config.headers["x-api-key"] = token;
    config.headers["X-API-KEY"] = token;
  } else {
    delete config.headers["x-api-key"];
    delete config.headers["X-API-KEY"];
  }

  if (!config.headers["Content-Type"]) {
    config.headers["Content-Type"] = "application/json";
  }

  return config;
});

// Interceptar las respuestas //
api.interceptors.response.use(
  (config) => config,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem("token");
      window.location.href = "/login";
    }
    // Devolvemos el mensaje sin perder trazas útiles
    return Promise.reject({
      message:
        error.response?.data?.message ||
        "Ocurrió un error sin respuesta del servidor",
      status: error.response?.status,
      data: error.response?.data,
      url: error.config?.url,
    });
  }
);
