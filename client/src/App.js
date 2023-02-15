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
import Admin from "./Components/Admin";

function App() {

  const [currentPage,setCurrentPage] = useState("");
  const [currentShowData,setCurrentShowData] = useState([]);
  const navigate = useNavigate();
  const [api,setApi] = useState("http://localhost:8080/api");
  const [token,setToken] = useState(localStorage.getItem("token"));
  const [user,setUser] = useState([]);
  const [role,setRole] = useState("");
  const [isAuthenticated,setIsAuthenticated] = useState(false);


  const config = {
      headers: { 
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
      }
  };
  const getCurrentUser = ()=> {
    const datas = {};
    axios.get(`${api}/users/me`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
      response => {
          if( response.status === 200) {
            
            setUser(response.data[0]);
            setUser(response.data[0]);
            console.log(user);
          }
      }
    )
  }
 
  useEffect( () =>{
    getCurrentUser()  
  },[isAuthenticated]);

  useEffect( () =>{
    getCurrentUser();
  },[]);

  useEffect( () =>{
    if(currentPage == "boutiques") {
        navigate('/boutiques'); 
    } else if(currentPage == "produits") {
        navigate('/produits'); 
    } else if(currentPage == "categories") {
      navigate('/categories'); 
    }
    else if(currentPage == "administrateur") {
      navigate('/administrateur'); 
    }
  },[currentPage]);

  

  return (
    <div className="App">
       <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/register" element={<Register api = {api}/>} />
          <Route path="/login" element={<Login changeToken = {(newToken) => { setToken(newToken)}} api = {api} isAuthenticated = {isAuthenticated}  changeIsAuthenticated = {(new_is_auth)=> {setIsAuthenticated(new_is_auth)}}/>} />
          <Route path="/boutiques" element={<Boutiques user = {user} token = {token} api = {api} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}} changeUser= {(new_user)=>{setUser(new_user)}} />} />
          <Route path="/boutiques/:id"  element={<ShowBoutique  currentShowData = {currentShowData} token = {token} api = {api} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}} />} />
          <Route path="/produits" element={<Produits user = {user} api = {api} token = {token} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage} changeCurrentShowDataProduit = {(new_data)=>{setCurrentShowData(new_data)}} changeUser= {(new_user)=>{setUser(new_user)}} />}  />
          <Route path="/produits/:id" element={<ShowProduit currentShowData = {currentShowData} token = {token} api = {api} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}}  />} />
          <Route path="/categories" element={<Categories user = {user} token = {token} api = {api} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage}  changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}} changeUser= {(new_user)=>{setUser(new_user)}}  />} />
          <Route path="/categories/:id" element={<ShowCategorie currentShowData = {currentShowData} token = {token} api = {api} changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}}  />} />
          <Route path="/me" element={<ShowProfile  user = {user}/>} />
          <Route path="/administrateur" element={<Admin user = {user} token = {token} api = {api} confing = {config} change_current_page = {(new_page)=> {setCurrentPage(new_page)}} currentPageSwitch={currentPage}  changeCurrentShowData = {(new_data)=>{setCurrentShowData(new_data)}} changeUser= {(new_user)=>{setUser(new_user)}}  />} />

       </Routes>
       <Footer/>
    </div>
  );
}

export default App;
