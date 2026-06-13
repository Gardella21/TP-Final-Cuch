import { api } from "./api";

export const bookReservationService = {
  create: (data) => api.post("/book-reservations", data),
  getAll: ()     => api.get("/book-reservations"),
  updateEstado: (id, estado) =>
    api.put(`/book-reservations/${id}`, { id, estado }),
};
