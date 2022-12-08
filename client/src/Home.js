import { useState } from 'react';
import ReactDOM from 'react-dom/client';
import axios from "axios";

export default function Home() {
  const [inputs, setInputs] = useState({});

  const handleChange = (event) => {
    const name = event.target.name;
    const value = event.target.value;
    
    setInputs(values => ({...values, [name]: value}))
  }

  const handleSubmit = async (event) => {
    event.preventDefault();
    alert(inputs);
    const form_data = new FormData();
    form_data.append('name', inputs.username);
    form_data.append('password', inputs.password);
    console.log(form_data)
    let res = await axios.post('http://127.0.0.1', form_data, 
        { headers: {
                                  'Content-Type': 'application/json',
                              }, });
    console.log(res)
    let data = res.data;
  }

  return (
    <form onSubmit={handleSubmit}>
      <label>userName:
      <input 
        type="text" 
        name="username" 
        value={inputs.username || ""} 
        onChange={handleChange}
      />
      </label>
      <label>password:
        <input 
          type="password" 
          name="password" 
          value={inputs.password || ""} 
          onChange={handleChange}
        />
        </label>
        <input type="submit" />
    </form>
  )

}