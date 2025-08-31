import "./App.css";
import "@mantine/core/styles.css";

import { MantineProvider } from "@mantine/core";
import { RegisterPage } from "./pages/RegisterPage/RegisterPage";
import { LoginPage } from "./pages/LoginPage/LoginPage";
import { BrowserRouter, Routes, Route } from "react-router";
import { HomePage } from "./pages/HomePage/HomePage";
import { PrivateRoute, PublicRoute } from "./Routes";
import Login from './pages/Login/Login';
import NavBar from './components/NavBar/NavBar';
import InfoNosotros from './components/InfoNosotros/InfoNosotros';
import Register from './pages/Register/Register';

function App() {
	return (
		<MantineProvider defaultColorScheme="dark">
			<BrowserRouter>
				<NavBar />
				<Routes>
					{/*Rutas públicas*/}
					<Route element={<PublicRoute />}>
					    <Route path='/' element={<></>}/>
						<Route path='/noticias' element={<></>}/>
						<Route path='/cursos-y-eventos' element={<></>}/>
						<Route path='/nosotros' element={<InfoNosotros/>}/>
						<Route path='/socios' element={<></>}/>
						<Route path='/catalogo' element={<></>}/>
						<Route path='/donaciones' element={<></>}/>
						<Route path='/users/login' element={<Login/>}/>
						<Route path='/users' element={<Register/>}/>
						<Route path="/login" element={<LoginPage />} />
						<Route path="/register" element={<RegisterPage />} />
					</Route>

					{/*Rutas privadas */}
					<Route element={<PrivateRoute />}>
						<Route path="/home" element={<HomePage />} />
					</Route>
				</Routes>
			</BrowserRouter>
		</MantineProvider>
	);
}

export default App;