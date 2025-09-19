import "./App.css";
import "@mantine/core/styles.css";

import { MantineProvider } from "@mantine/core";
import { RegisterPage } from "./pages/RegisterPage/RegisterPage";
import { LoginPage } from "./pages/LoginPage/LoginPage";
import { BrowserRouter, Routes, Route, Outlet } from "react-router";
import { HomePage } from "./pages/HomePage/HomePage";
import { PrivateRoute, PublicRoute } from "./Routes";
import Header from "./components/Header/Header";
import NavBar from './components/NavBar/NavBar';
import Banner from "./components/Banner/Banner";
import Footer from "./components/Footer/Footer";
import InfoNosotros from './components/InfoNosotros/InfoNosotros';
import { DonationsPage } from "./pages/DonationsPage/DonationsPage";
import Questions from './components/Questions/Questions';
import InscriptionPage from "./pages/InscriptionPage/InscriptionPage";
import { ArticleManagerPage } from "./pages/Admin/Article/ArticleManagerPage";
import { ArticleCreationPage } from "./pages/Admin/Article/ArticleCreationPage";
import { ArticlePage } from "./pages/ArticlePage/ArticlePage";
import { ArticlePageDetail } from "./pages/ArticlePageDetail/ArticlePageDetail";
import { CatalogPage } from "./pages/CatalogPage/CatalogPage";

const MainLayout = () => (
  <>
    <Header />
    <NavBar />
	
    <Outlet /> {/* Renders nested routes */}
	<Footer />   
  </>
);

function App() {
	return (
		<MantineProvider defaultColorScheme="dark">
			<BrowserRouter>
				<Routes>
					{/* Rutas con la barra de navegacion estandar */}
					<Route element={<MainLayout />}>
					    <Route path='/' element={<><Banner/> </>}/>
						<Route path='/noticias' element={<ArticlePage/>} />
                        <Route path='/articles/:id' element={<ArticlePageDetail/>} />
						<Route path='/cursos-y-eventos' element={<InscriptionPage/>}/>
						<Route path='/nosotros' element={<InfoNosotros/>}/>
						<Route path='/catalogo' element={<CatalogPage/>}/>
						<Route path='/donaciones' element={<DonationsPage/>}/>
                        <Route path='/preguntas' element={<Questions />} />
					</Route>

					{/*Rutas inaccesibles con token activo*/}
					<Route element={<PublicRoute />}>
						<Route path="/login" element={<LoginPage />} />
						<Route path="/register" element={<RegisterPage />} />
					</Route>

					{/*Rutas inaccesibles sin token activo */}
					<Route element={<PrivateRoute />}>
						<Route path="/admin/article" element={<ArticleManagerPage />} />
						<Route path="/admin/article-new" element={<ArticleCreationPage />} />
					</Route>
				</Routes>
			</BrowserRouter>
		</MantineProvider>
	);
}

export default App;