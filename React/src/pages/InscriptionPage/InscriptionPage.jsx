import { TextInput, Container, Button, Title } from "@mantine/core";
import "./InscriptionPage.css";
import { z } from "zod";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { useState } from "react";
import { inscriptionService } from "../../services/inscriptionService";
import { useParams } from "react-router-dom";

const UserSchema = z.object({
  name: z.string().min(3, "Debe tener como mínimo 3 caracteres").max(48),
  surname: z.string().min(3, "Debe tener como mínimo 3 caracteres").max(48),
  email: z.string().email("El correo electrónico no es válido").max(48),
  phone: z
    .string()
    .regex(/^\d+$/, "Debe contener solo números")
    .min(7, "Debe tener mínimo 7 dígitos")
    .max(15, "Debe tener máximo 15 dígitos"),
});

function InscriptionPage() {
  const { id_event } = useParams(); // ← viene como string
  const eventId = parseInt(id_event ?? "", 10); // ← convertir a número

  const form = useForm({
    resolver: zodResolver(UserSchema),
    defaultValues: { name: "", surname: "", email: "", phone: "" },
  });

  const [error, setError] = useState(undefined);

  const onSubmit = async (formData) => {
  try {
    setError(undefined);

    if (Number.isNaN(eventId)) {
      throw new Error("Evento inválido.");
    }

    const payload = { ...formData, id_event: eventId };

    const resp = await inscriptionService.createInscription(payload);

    if (resp?.status === 201 || resp?.status === 200 || resp?.data?.status === 200) {
      alert("Inscripción enviada ");

      form.reset();  

      setError(undefined);
    } else {
      throw new Error("Ocurrió un error inesperado");
    }
  } catch (e) {
    console.error("Inscripción error:", e?.response?.status, e?.response?.data || e);
    setError(e?.message ?? "Error al guardar la inscripción.");
  }
};


  return (
    <main className="inscription-page">
      <Container className="inscription-section">
        <Title>Formulario de Inscripción</Title>

        <form onSubmit={form.handleSubmit(onSubmit)}>
          <TextInput
            className="TextInput"
            placeholder="Nombre"
            error={form.formState.errors.name?.message}
            {...form.register("name")}
          />
          <TextInput
            className="TextInput"
            placeholder="Apellido"
            error={form.formState.errors.surname?.message}
            {...form.register("surname")}
          />
          <TextInput
            className="TextInput"
            placeholder="Correo electrónico"
            error={form.formState.errors.email?.message}
            {...form.register("email")}
          />
          <TextInput
            className="TextInput"
            placeholder="Número de contacto"
            error={form.formState.errors.phone?.message}
            {...form.register("phone")}
          />

          {/* Mostrar error si lo hay */}
          {error && <div style={{ color: "crimson", margin: "8px 0" }}>{error}</div>}

          <Button
            className="inscriptinoButton"
            variant="filled"
            type="submit" // 👈 submit
            loading={form.formState.isSubmitting}
          >
            Inscribirme
          </Button>
        </form>
      </Container>
    </main>
  );
}

export default InscriptionPage;
