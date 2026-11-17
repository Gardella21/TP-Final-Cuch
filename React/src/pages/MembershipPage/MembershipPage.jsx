import { TextInput, Container, Button, Title, Text } from "@mantine/core";
import "./MembershipPage.css";
import { z } from "zod";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { useState } from "react";
import { memberService } from "../../services/memberService";

const MemberSchema = z.object({
  name: z.string().min(3, "Debe tener como mínimo 3 caracteres").max(48),
  surname: z.string().min(3, "Debe tener como mínimo 3 caracteres").max(48),
  dni: z
    .string()
    .regex(/^\d+$/, "Debe contener solo números")
    .min(7, "Debe tener mínimo 7 dígitos")
    .max(9, "Debe tener máximo 9 dígitos"),
  email: z.string().email("El correo electrónico no es válido").max(48),
  phone: z
    .string()
    .regex(/^\d+$/, "Debe contener solo números")
    .min(7, "Debe tener mínimo 7 dígitos")
    .max(15, "Debe tener máximo 15 dígitos"),
  address: z.string().min(5, "Debe tener como mínimo 5 caracteres").max(100),
  birth_date: z.string().min(1, "Debe ingresar su fecha de nacimiento"),
});

function MembershipPage() {
  const form = useForm({
    resolver: zodResolver(MemberSchema),
    defaultValues: {
      name: "",
      surname: "",
      dni: "",
      email: "",
      phone: "",
      address: "",
      birth_date: "",
    },
  });

  const [error, setError] = useState(undefined);
  const [success, setSuccess] = useState(false);

  const onSubmit = async (formData) => {
    try {
      setError(undefined);
      setSuccess(false);

      const resp = await memberService.createMember(formData);

      if (resp?.status === 201 || resp?.status === 200) {
        form.reset();
        setSuccess(true);
      } else {
        throw new Error("Ocurrió un error inesperado");
      }
    } catch (e) {
      console.error("Asociación error:", e?.response?.status, e?.response?.data || e);
      setError(e?.message ?? "Error al enviar la solicitud.");
    }
  };

  return (
    <main className="membership-page">
      <Container className="membership-section">
        <Title>Hacete socio</Title>

        {success ? (
          <div className="membership-success-box">
            <Text className="successMessage" size="lg" fw={700}>
              ¡Tu solicitud fue registrada!
            </Text>
            <Text className="membership-info">
              Acercate a la biblioteca con tu DNI para finalizar el trámite y
              activar tu membresía. Te esperamos en el horario de atención al
              público.
            </Text>
            <Button
              className="membershipButton"
              onClick={() => setSuccess(false)}
            >
              Cargar otra solicitud
            </Button>
          </div>
        ) : (
          <>
            <Text className="membership-info">
              Completá el formulario para iniciar tu asociación. Luego acercate
              a la biblioteca con tu DNI para finalizar el trámite.
            </Text>

            <form onSubmit={form.handleSubmit(onSubmit)}>
              <TextInput
                label="Nombre"
                placeholder="Tu nombre"
                {...form.register("name")}
                error={form.formState.errors.name?.message}
              />
              <TextInput
                label="Apellido"
                placeholder="Tu apellido"
                {...form.register("surname")}
                error={form.formState.errors.surname?.message}
              />
              <TextInput
                label="DNI"
                placeholder="Sin puntos"
                {...form.register("dni")}
                error={form.formState.errors.dni?.message}
              />
              <TextInput
                label="Email"
                placeholder="tucorreo@mail.com"
                {...form.register("email")}
                error={form.formState.errors.email?.message}
              />
              <TextInput
                label="Teléfono"
                placeholder="2346123456"
                {...form.register("phone")}
                error={form.formState.errors.phone?.message}
              />
              <TextInput
                label="Domicilio"
                placeholder="Calle y número"
                {...form.register("address")}
                error={form.formState.errors.address?.message}
              />
              <TextInput
                label="Fecha de nacimiento"
                type="date"
                {...form.register("birth_date")}
                error={form.formState.errors.birth_date?.message}
              />

              <Button
                className="membershipButton"
                type="submit"
                loading={form.formState.isSubmitting}
              >
                Enviar solicitud
              </Button>
            </form>

            {error && <p className="errorMessage">{error}</p>}
          </>
        )}
      </Container>
    </main>
  );
}

export default MembershipPage;