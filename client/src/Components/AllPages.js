import React from 'react'

const AllPages = ({current_page,all_pages,get_page}) => {

    const all_pages_array = Array.apply(null, {length : all_pages}).map(Number.call, Number); // a array of all pages
    
    // show all pags list
    const show_pages = () =>{
        
             document.querySelector('.all_pages').classList.toggle('show_me');
    }

    return (

       
        <div className='filter-container'>
                <span className="c_item" onClick = { ()=> { show_pages(); }}>page : <strong> {current_page} </strong> </span>

                <div className="all_pages">

                        {
                        all_pages_array.map( (page) =>(
                                
                                <span onClick = { ()=> { get_page(page+1);show_pages(); }}>page : {parseInt(page)+1 }</span>
                        ))
                        
                        }
                </div>

        </div>

)
}

export default AllPages