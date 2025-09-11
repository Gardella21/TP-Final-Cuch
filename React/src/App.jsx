import "./App.css";
import "@mantine/core/styles.css";

import { MantineProvider } from "@mantine/core";
import { RegisterPage } from "./pages/RegisterPage/RegisterPage";
import { LoginPage } from "./pages/LoginPage/LoginPage";
import { BrowserRouter, Routes, Route } from "react-router";
import { HomePage } from "./pages/HomePage/HomePage";
import { PrivateRoute, PublicRoute } from "./Routes";
import Header from "./components/Header/Header";
import NavBar from './components/NavBar/NavBar';
import InfoNosotros from './components/InfoNosotros/InfoNosotros';
import { DonationsPage } from "./pages/DonationsPage/DonationsPage";
import Questions from './components/Questions/Questions';


import InscriptionPage from "./pages/InscriptionPage/InscriptionPage";

function App() {
	return (
		<MantineProvider defaultColorScheme="dark">
			<BrowserRouter>
			    <Header />
				<NavBar />
				<Routes>
					<Route path='/' element={<></>}/>
					<Route path='/noticias' element={<></>}/>
					<Route path='/cursos-y-eventos' element={<InscriptionPage/>}/>
					<Route path='/nosotros' element={<InfoNosotros/>}/>
					<Route path='/catalogo' element={<></>}/>
					<Route path='/donaciones' element={<DonationsPage/>}/>
					<Route path='/preguntas' element={<Questions />} />

					{/*Rutas públicas*/}
					<Route element={<PublicRoute />}>
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