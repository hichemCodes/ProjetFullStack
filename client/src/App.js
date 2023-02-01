import { Routes, Route, useNavigate } from "react-router-dom";
import { useEffect, useState } from 'react';
import Home from "./Components/Home";
import Register from "./Components/Register";
import Login from "./Components/Login";
import Boutiques from "./Components/Boutiques";
import Produits from "./Components/Produits";
import ShowBoutique from "./Components/ShowBoutique";
import axios from 'axios';
import Categories from "./Components/Categories";
import ShowProfile from "./Components/ShowProfile";
import './styles/App.css';
import ShowProduit from "./Components/ShowProduit";
import ShowCategorie from "./Components/ShowCategorie";
import Footer from "./Components/Footer";



function App() {

  const [currentPage,setCurrentPage] = useState("");
  const [currentShowData,setCurrentShowData] = useState([]);
  const navigate = useNavigate();
  const [api,setApi] = useState("http://localhost:8080/api");
  const [token,setToken] = useState(localStorage.getItem("token"));
  const [user,setUser] = useState([]);
  const [role,setRole] = useState("");

  const config = {
      headers: { 
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
      }
  };

  useEffect( () =>{
    //get current user 
    const datas = {};
    axios.get(`${api}/user/me`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
      response => {
          if( response.status === 200) {
            setUser(response.data[0]);
            console.log(user);
          }
      }
    )
    console.log(currentShowData);
  },[currentShowData]);

  useEffect( () =>{
  
    if(currentPage == "boutiques") {
        navigate('/boutiques'); 
    } else if(currentPage == "produits") {
        navigate('/produits'); 
    } else if(currentPage == "categories") {
      navigate('/categories'); 
    }

  },[currentPage]);

  

  return (
    <div className="App">
       <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/register" element={<Register api = {api}/>} />
          <Route path="/login" element={<Login changeToken = {(newToken) => { setToken(newToken)}} api = {api} />} />
          <Route path="/boutiques" element={<Boutiques user = {user} token = {token} api = {api} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}}/>} />
          <Route path="/boutiques/:id"  element={<ShowBoutique  currentShowData = {currentShowData} token = {token} api = {api} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}} />} />
          <Route path="/produits" element={<Produits user = {user} api = {api} token = {token} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage} changeCurrentShowDataProduit = {(new_data)=>{setCurrentShowData(new_data)}}/>}  />
          <Route path="/produits/:id" element={<ShowProduit currentShowData = {currentShowData} token = {token} api = {api} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}}  />} />
          <Route path="/categories" element={<Categories user = {user} token = {token} api = {api} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage}  changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}} />} />
          <Route path="/categories/:id" element={<ShowCategorie currentShowData = {currentShowData} token = {token} api = {api} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}}  />} />
          <Route path="/me" element={<ShowProfile  user = {user}/>} />
       </Routes>
       <Footer/>
    </div>
  );
}

export default App;
