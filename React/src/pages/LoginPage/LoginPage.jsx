import "./LoginPage.css";
import { Link, useNavigate } from "react-router-dom";
import {
  Button,
  Container,
  PasswordInput,
  Text,
  TextInput,
  Title,
  Alert,
} from "@mantine/core";
import { z } from "zod";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { authService } from "../../services/authService";
import { useState, useEffect } from "react";

const UserSchema = z.object({
  email: z
    .email("El correo electrónico no es válido")
    .max(48, "Debe tener máximo 48 caracteres"),
  password: z
    .string("La contraseña no es válida")
    .min(4, "Debe tener mínimo 4 caracteres")
    .max(32, "Debe tener máximo 32 caracteres"),
});

export function LoginPage() {
  const form = useForm({ resolver: zodResolver(UserSchema) });
  const navigate = useNavigate();
  const [error, setError] = useState(undefined);
  const [pendingMsg, setPendingMsg] = useState(undefined);

  // auto-ocultar alertas a los 6s
  useEffect(() => {
    if (!pendingMsg) return;
    const t = setTimeout(() => setPendingMsg(undefined), 6000);
    return () => clearTimeout(t);
  }, [pendingMsg]);

  useEffect(() => {
    if (!error) return;
    const t = setTimeout(() => setError(undefined), 6000);
    return () => clearTimeout(t);
  }, [error]);

  // Mapea payload de backend a mensajes claros
  function mapBackendToMessage(status, payload) {
    const raw =
      (typeof payload === "string" ? payload : payload?.error || payload?.message || "") || "";

    // pendiente / no autorizado
    if ((status === 401 || status === 403) && /autorizad|pendient|aprobaci|inactiv/i.test(raw)) {
      return {
        pending:
          "Tu solicitud aún está pendiente. Un administrador debe aprobarla antes de iniciar sesión.",
      };
    }
    // credenciales inválidas
    if (status === 401 || /credencial|password|contrase(?:ñ|n)a|clave|incorrect/i.test(raw)) {
      return { error: "Correo o contraseña incorrectos." };
    }
    // email inválido
    if (status === 400 && /email|correo/i.test(raw)) {
      return { error: "El correo electrónico no es válido." };
    }
    // fallback
    if (raw) return { error: raw };
    return { error: "Error al iniciar sesión" };
  }

  async function onSubmit(formData) {
    try {
      setError(undefined);
      setPendingMsg(undefined);

      // Enviar el OBJETO (Axios lo serializa), no stringify
      const response = await authService.login(formData);

      // Si tu Axios no rechaza 4xx/5xx:
      if (response?.status && response.status >= 400) {
        const msg = mapBackendToMessage(response.status, response.data);
        if (msg.pending) setPendingMsg(msg.pending);
        if (msg.error) setError(msg.error);
        return;
      }

      const data = response?.data || {};
      const headers = response?.headers || {};
      const user = data?.user || {};

      // Token tolerante (varias ubicaciones)
      const token =
        user?.token ??
        data?.token ??
        headers["x-api-key"] ??
        headers["X-API-KEY"] ??
        data?.auth?.token ??
        null;

      if (!token) {
        try {
          localStorage.removeItem("token");
        } catch {}
        throw new Error("El servidor no devolvió un token válido");
      }

      // Normalizar SIEMPRE en la misma key: current_user
      const normalizado = {
        id: user.id,
        email: user.email,
        role: user.role,
        nombre: user.nombre ?? user.name ?? "",
        apellido: user.apellido ?? user.lastName ?? "",
      };

      // Guardado consistente
      localStorage.setItem("token", token);
      if (normalizado.role) {
        localStorage.setItem("role", String(normalizado.role).toLowerCase());
      }
      localStorage.setItem("current_user", JSON.stringify(normalizado));

      // Avisar al header (avatar) que cambió el usuario
      window.dispatchEvent(new Event("auth:user-changed"));

      navigate("/admin");
    } catch (err) {
      // Caso normal: Axios rechazó (status no-2xx)
      const status = err?.response?.status;
      const data = err?.response?.data;
      const msg = mapBackendToMessage(status, data);
      if (msg.pending) setPendingMsg(msg.pending);
      if (msg.error) setError(msg.error);
      console.error("Error en login:", err);
    }
  }

  return (
    <main className="loginPage">
      <Container className="container">
        <header>
          <Title>Bienvenido!</Title>
        </header>

        {/* Solicitud pendiente */}
        {pendingMsg ? (
          <Alert className="pendingMsg" color="blue" variant="filled" radius="md" mt="md">
            {pendingMsg}
          </Alert>
        ) : null}

        {/* Errores (credenciales/email) */}
        {error ? (
          <Alert className="errorMsg" color="red" variant="light" radius="md" mt="md">
            {error}
          </Alert>
        ) : null}

        <form>
          <TextInput
            placeholder="Correo electrónico"
            error={form.formState.errors.email?.message}
            {...form.register("email")}
          />
          <PasswordInput
            placeholder="Contraseña"
            error={form.formState.errors.password?.message}
            {...form.register("password")}
          />
          <Button
            fullWidth
            mt="md"
            variant="filled"
            onClick={form.handleSubmit(onSubmit)}
            loading={form.formState.isSubmitting}
          >
            Iniciar sesión
          </Button>

          <Text ta="center" mt="md">
            ¿Aún no tienes una cuenta? <Link to="/register">Registrarse</Link>
          </Text>
        </form>
      </Container>
    </main>
  );
}
