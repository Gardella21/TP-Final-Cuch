import './NavBar.css';
import { AppBar, Toolbar, Button, Box, Container } from '@mui/material';
import { Link, useLocation } from 'react-router-dom';

const navItems = [
  { name: 'Noticias', route: '/noticias' },
  { name: 'Cursos y eventos', route: '/cursos-y-eventos' },
  { name: 'Nosotros', route: '/nosotros' },
  { name: 'Socios', route: '/socios' },
  { name: 'Catálogo', route: '/catalogo' },
  { name: 'Donaciones', route: '/donaciones' },
  { name: 'Login', route: '/users/login' } //temporal para test
];

const Navbar = () => {
  const location = useLocation(); // para saber qué ruta está activa
  
  return (
    <AppBar position="static" color="primary">
      <Container maxWidth="lg">
        <Toolbar disableGutters sx={{ justifyContent: 'space-between' }}>
          {/* Categorías centradas */}
          <Box className="NavBox">
            {navItems.map((item) => (
              <Button 
                key={item.name} 
                component={Link}
                to={item.route} 
                className={`NavButton ${
                  location.pathname === item.route ? 'active' : ''
                }`}
              >
                {item.name}
              </Button>
            ))}
          </Box>
        </Toolbar>
      </Container>
    </AppBar>
  );
};

export default Navbar;
