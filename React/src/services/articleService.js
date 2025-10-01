import { api } from "./api";

export const articleService = {
    getAllArticles: () => api.get("/articles"),
    getArticleById: (id) => api.get("/articles/" + id),
    createArticle: (data) => api.post("/articles", data),
    deleteArticleById: (id) => api.delete("/articles" + id),
    updateArticle: (id, data) => api.put("/articles" + id,data)
};
