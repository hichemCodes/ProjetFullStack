import { Routes, Route, useNavigate } from "react-router-dom";
import { useEffect, useState } from 'react';
import Home from "./Components/Home";
import Register from "./Components/Register";
import Login from "./Components/Login";
import Boutiques from "./Components/Boutiques";
import ShowBoutique from "./Components/ShowBoutique";
import './styles/App.css';



function App() {

  const [currentPage,setCurrentPage] = useState("");
  const navigate = useNavigate();

  useEffect( () =>{
    if(currentPage == "boutiques") {
        navigate('/boutiques'); 
    } else if(currentPage == "produits") {
        navigate('/produits'); 
    }
    console.log("run");
  },[currentPage]);

  return (
    <div className="App">
       <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/register" element={<Register />} />
          <Route path="/login" element={<Login />} />
          <Route path="/boutiques" element={<Boutiques change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage}/>} />
          <Route path="/boutiques/{:id}" element={<ShowBoutique />} />
       </Routes>
    </div>
  );
}

export default App;
