import Link from '@mui/material/Link';
import './Register.css';
import Button from '@mui/material/Button';

function Register(){
return(
    <>
<div className='Contenedor_Login'>
        
     <div className='Contenedor_Formulario'>
        <form className="Formulario">
      <input type="text" name="Nombre" id="Nombre" placeholder='Nombre' />
      <input type="email" name="Correo" id="Correo" placeholder='Correo Electronico' />
      <input type="password" name="Password" id="Password" placeholder='Contraseña' />
     <Button variant="contained" size="small" className='Boton_Login'>
          Registrarse
        </Button>

     </form>
     </div>
</div>
     
    
    </>
)
}

export default Register