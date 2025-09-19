import { api } from "./api";

export const eventService = {
    getAllEvents: () => api.get("/events"),
    createDomain: (data) => api.post("/events", data),
};
