import { api } from "./api";

export const fileService = {
    UploadFile : (data) => api.post("/files/upload", data)
              .then(response => {
                  return response;
              })
};
