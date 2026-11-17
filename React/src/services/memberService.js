import { api } from "./api";

export const memberService = {
  // Publico: envia la solicitud de asociacion //
  createMember: (data) => api.post("/members", data),

  // Admin: lista todas las solicitudes //
  getMembers: () => api.get("/members"),

  // Admin: cambia el estado de una solicitud //
  updateEstado: (id, estado) => api.put(`/members/${id}`, { estado }),
};
