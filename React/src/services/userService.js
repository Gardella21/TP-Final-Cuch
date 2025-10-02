import { api } from "./api";

// Headers con token
const getHeaders = () => {
  const token = localStorage.getItem("token");
  return {
    "Content-Type": "application/json",
    "X-API-KEY": token,
  };
};

export const userService = {
  // Lista usuarios activos //
  getAllActive: () => api.get("/users/active", { headers: getHeaders() }),

  // Lista solicitudes pendientes //
  getPending: () => api.get("/users/pending", { headers: getHeaders() }),

  // Buscar usuario por email //
  searchByEmail: (email) =>
    api.get(`/users/search?email=${email}`, { headers: getHeaders() }),

  // Actualizar usuario (rol y estado) //
  update: (data) =>
    api.put("/users", data, { headers: getHeaders() }),

  // Eliminar usuario //
  delete: (id) =>
    api.delete(`/users/${id}`, { headers: getHeaders() }),

  // Aprobar solicitud pendiente //
  approve: (id) =>
    api.put(`/users/approve/${id}`, null, { headers: getHeaders() }),

  // Rechazar solicitud pendiente //
  reject: (id) =>
    api.delete(`/users/${id}`, { headers: getHeaders() }),
};
