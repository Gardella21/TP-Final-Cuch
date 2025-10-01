import React, { useEffect, useState } from 'react';
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
import { authService } from '../../services/authService';

const AdminNavBar = () => {
  const [openDrawer, setOpenDrawer] = useState(false);
  const [user, setUser] = useState("");

  const findUser = async () => {  // Se almacena el usuario verificado
    setUser(await authService.verify());
  }
    useEffect(() => {
      findUser();
    }, []); 

  const toggleDrawer = (open) => () => setOpenDrawer(open);

  const handleLogout = () => {
      localStorage.removeItem("token"); // remueve el token y redirige al login
			window.location.href = "/login";
    }

  return (
    <>
      <AppBar position="static" className="admin-navbar">
        <Toolbar className="admin-toolbar">
          <div className="logo-container">
            <Link to="/admin">
              <img src={logo} alt="Logo" className="logo" />
            </Link>
          </div>

          <Typography variant="h4" className="welcome-panel">
            Panel Administrativo
          </Typography>

          <Box sx={{ flexGrow: 1 }} />

          <div className="user-section desktop-only">
            <Box className="user-text">
              <Typography variant="body1" className="welcome-text">
                {user?.data?.name}
              </Typography>
              <Typography
                variant="body2"
                className="logout-text"
                onClick={handleLogout}
              >
                Cerrar sesión
              </Typography>
            </Box>
            <Avatar>{user?.data?.name[0]+user?.data?.name[1]}</Avatar>
          </div>

          <IconButton
            edge="end"
            color="inherit"
            aria-label="menu"
            onClick={toggleDrawer(true)}
            className="mobile-only"
          >
            <MenuIcon fontSize="large" />
          </IconButton>
        </Toolbar>
      </AppBar>

      <Drawer anchor="right" open={openDrawer} onClose={toggleDrawer(false)}>
        <Box
          sx={{
            width: 250,
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',
            mt: 4
          }}
          role="presentation"
          onClick={toggleDrawer(false)}
          onKeyDown={toggleDrawer(false)}
        >
          <Avatar sx={{ mb: 1, width: 60, height: 60 }}>{user?.data?.name[0]+user?.data?.name[1]}</Avatar>
          <Typography variant="body1" sx={{ mb: 2, fontWeight: 'bold' }}>
          {user?.data?.name}
          </Typography>

          <Divider sx={{ width: '100%', mb: 2 }} />

          <List sx={{ width: '100%' }}>
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
            <Divider sx={{ my: 2 }} />
            <ListItem disablePadding>
              <ListItemButton onClick={handleLogout}>
                <ListItemText primary="Cerrar sesión" />
              </ListItemButton>
            </ListItem>
          </List>
        </Box>
      </Drawer>
    </>
  );
};

export default AdminNavBar;
