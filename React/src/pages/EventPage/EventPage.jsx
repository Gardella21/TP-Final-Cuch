import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import CardActions from '@mui/material/CardActions';
import Button from '@mui/material/Button';
import "./EventPage.css"
import { useNavigate } from "react-router-dom";
import { useEffect, useState } from 'react';
import { eventService } from "../../services/eventService";



const style = {
  position: 'absolute',
  top: '50%',
  left: '50%',
  transform: 'translate(-50%, -50%)',
  width: 400,
  bgcolor: 'background.paper',
  border: '2px solid #000',
  boxShadow: 24,
  p: 4,
};

function EventPage(){
    
    const navigate = useNavigate();
    const ToForm = (id) => {
  navigate(`/cursos-y-eventos/form/${id}`); 
};



    const [ events, setEvents ] = useState(undefined)
    async function fetchData(){
      const response = await eventService.getAllEvents()
      setEvents(response.data)
    }

    useEffect(() => {
      fetchData()
    }, [])

  
  const response = []
                    

return(
  <main id="eventos"className="event-page">
    {
      events ? events.map(curso=>{
      return <Card key={curso.id} className="event-Card" variant="outlined">
      <CardContent>
        {/* Imagen del evento */}
        {curso.image ? (
          <img
            src={curso.image}
            alt={curso.title}
            className="event-image"
          />
        ) : (
          <div className="event-image-placeholder">
            <p>Sin imagen disponible</p>
          </div>
        )}
        <h1>{curso.title}</h1>
        <p>{curso.description}</p>
        <p>Fecha de Finalización:{" "}
          {curso.end_date
            ? new Date(curso.end_date).toLocaleDateString("es-AR", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
              })
            : "-"}</p>
      </CardContent>
      <CardActions>
        <Button size="small"
                onClick={() => ToForm(curso.id)}
        >
          Inscribirse</Button>
        
      </CardActions>
      </Card >

    }) :<p> Cargando...</p>
    }


    
  </main>
);
}

export default EventPage