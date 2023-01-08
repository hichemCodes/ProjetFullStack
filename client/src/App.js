import { Routes, Route, useNavigate } from "react-router-dom";
import { useEffect, useState } from 'react';
import Home from "./Components/Home";
import Register from "./Components/Register";
import Login from "./Components/Login";
import Boutiques from "./Components/Boutiques";
import Produits from "./Components/Produits";
import ShowBoutique from "./Components/ShowBoutique";
import './styles/App.css';



function App() {

  const [currentPage,setCurrentPage] = useState("");
  const [currentShowData,setCurrentShowData] = useState("");
  const navigate = useNavigate();
  const [api,setApi] = useState("http://localhost:8080/api");
  const [token,setToken] = useState(localStorage.getItem("token"));
  const config = {
      headers: { 
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
      }
  };

  useEffect( () =>{
    if(currentPage == "boutiques") {
        navigate('/boutiques'); 
    } else if(currentPage == "produits") {
        navigate('/produits'); 
    }
  },[currentPage]);

  

  return (
    <div className="App">
       <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/register" element={<Register />} />
          <Route path="/login" element={<Login api = {api} />} />
          <Route path="/boutiques" element={<Boutiques api = {api} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}}/>} />
          <Route path="/boutiques/:id" element={<ShowBoutique currentShowData = {currentShowData}  />} />
          <Route path="/produits" element={<Produits api = {api} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage}/>} />
       </Routes>
    </div>
  );
}

export default App;
