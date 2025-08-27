
import './App.css';
import { BrowserRouter ,Routes ,Route } from 'react-router-dom';
import Login from './pages/Login/Login';
import NavBar from './components/NavBar/NavBar';
import InfoNosotros from './components/InfoNosotros/InfoNosotros';
import Register from './pages/Register/Register';



function App() {
 
  return (
   <div className='All'>
     <>
      <BrowserRouter>
        <NavBar/>
        <Routes>
          <Route path='/' element={<></>}/>
          <Route path='/noticias' element={<></>}/>
          <Route path='/cursos-y-eventos' element={<></>}/>
          <Route path='/nosotros' element={<InfoNosotros/>}/>
          <Route path='/socios' element={<></>}/>
          <Route path='/catalogo' element={<></>}/>
          <Route path='/donaciones' element={<></>}/>
          <Route path='/users/login' element={<Login/>}/>
          <Route path='/users' element={<Register/>}/>

        </Routes>
      </BrowserRouter>
    </>
   </div>
  );
}

export default App
