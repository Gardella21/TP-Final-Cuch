import React from 'react';
import { AppBar, Toolbar, Button } from '@mui/material';
import { Link } from 'react-router-dom';
import './AdminNavBar.css';
import logo from '/Images/Logo.png'; //Temporal, cambiarlo por el otro logo

const AdminNavBar = () => {
  return (
    <AppBar position="static" className="admin-navbar">
      <Toolbar className="admin-toolbar">
        <div className="logo-container">
          <img src={logo} alt="Logo" className="logo" />
        </div>

        <div className="nav-buttons">
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
      </Toolbar>
    </AppBar>
  );
};

export default AdminNavBar;
