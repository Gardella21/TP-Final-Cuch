import React, { useState } from 'react';
import {
  AppBar,
  Toolbar,
  Button,
  Avatar,
  Typography,
  Box,
  IconButton,
  Drawer,
  List,
  ListItem,
  ListItemButton,
  ListItemText,
  Divider
} from '@mui/material';
import MenuIcon from '@mui/icons-material/Menu';
import { Link } from 'react-router-dom';
import './AdminNavBar.css';
import logo from '/Images/logo2.png';

const AdminNavBar = () => {
  const [openDrawer, setOpenDrawer] = useState(false);

  const handleLogout = () => {
    console.log("Cerrando sesión...");
  };

  const toggleDrawer = (open) => () => {
    setOpenDrawer(open);
  };

  return (
    <>
      <AppBar position="static" className="admin-navbar">
        <Toolbar className="admin-toolbar">
          <div className="logo-container">
            <Link to="/admin">
              <img src={logo} alt="Logo" className="logo" />
            </Link>
          </div>

          <div className="nav-buttons desktop-only">
            <Button color="inherit" component={Link} to="/admin/articles">
              Noticias
            </Button>
            <Button color="inherit" component={Link} to="/admin/events">
              Cursos y Eventos
            </Button>
            <Button color="inherit" component={Link} to="/admin/users">
              Usuarios
            </Button>
          </div>

          <Box sx={{ flexGrow: 1 }} />

          <div className="user-section desktop-only">
            <Box className="user-text">
              <Typography variant="body1" className="welcome-text">
                Bienvenido Usuario
              </Typography>
              <Typography
                variant="body2"
                className="logout-text"
                onClick={handleLogout}
              >
                Cerrar sesión
              </Typography>
            </Box>
            <Avatar alt="Usuario" src="/Images/avatar.png" />
          </div>

          <IconButton
            edge="end"
            color="inherit"
            aria-label="menu"
            onClick={toggleDrawer(true)}
            className="mobile-only"
          >
            <MenuIcon />
          </IconButton>
        </Toolbar>
      </AppBar>

      <Drawer anchor="right" open={openDrawer} onClose={toggleDrawer(false)}>
        <Box
          sx={{ width: 250 }}
          role="presentation"
          onClick={toggleDrawer(false)}
          onKeyDown={toggleDrawer(false)}
        >
          <Box className="drawer-logo">
            <img src={logo} alt="Logo" className="logo" />
          </Box>
          <Divider />

          <List>
            <ListItem disablePadding>
              <ListItemButton component={Link} to="/admin/articles">
                <ListItemText primary="Noticias" />
              </ListItemButton>
            </ListItem>
            <ListItem disablePadding>
              <ListItemButton component={Link} to="/admin/events">
                <ListItemText primary="Cursos y Eventos" />
              </ListItemButton>
            </ListItem>
            <ListItem disablePadding>
              <ListItemButton component={Link} to="/admin/users">
                <ListItemText primary="Usuarios" />
              </ListItemButton>
            </ListItem>
          </List>
          <Divider />

          <Box className="drawer-user">
            <Avatar alt="Usuario" src="/Images/avatar.png" sx={{ mb: 1 }} />
            <Typography variant="body1" className="welcome-text">
              Bienvenido Usuario
            </Typography>
            <Typography
              variant="body2"
              className="logout-text"
              onClick={handleLogout}
            >
              Cerrar sesión
            </Typography>
          </Box>
        </Box>
      </Drawer>
    </>
  );
};

export default AdminNavBar;
