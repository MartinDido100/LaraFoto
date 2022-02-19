let url = 'https://larafoto.azurewebsites.net'

window.addEventListener('load',() => {

    const buttons = document.querySelectorAll('.heart'); 
    const likesNumber = document.querySelectorAll('.likes-number');

    buttons.forEach(button => {
        button.addEventListener('click',()=>{
            if(button.classList.contains('btn-like')){

                button.classList.replace('btn-like','btn-dislike');
                button.setAttribute('src',`${url}/img/heart.png`)
                axios.get(`${url}/dislike/${button.dataset.id}`).then(res => {

                    if(res.data.like){
                        likesNumber.forEach(number => {
                            if(number.dataset.id == res.data.like.image_id){
                                let value = parseInt(number.innerHTML);
                                value--;
                                number.innerHTML = value;
                            }
                        })
                    }

                }).catch(err => console.log);

            }else{

                button.classList.replace('btn-dislike','btn-like');
                button.setAttribute('src',`${url}/img/heart-red.png`)

                axios.get(`${url}/like/${button.dataset.id}`).then(res => {

                    if(res.data.like){
                        likesNumber.forEach(number => {
                            if(number.dataset.id == res.data.like.image_id){
                                let value = parseInt(number.innerHTML);
                                value++;
                                number.innerHTML = value;
                            }
                        })
                    }

                }).catch(err => console.log);

            }


        })
    })

    const searchForm = document.getElementById('searchForm');

    searchForm.addEventListener('submit',(event) => {
        event.preventDefault();
        const value = document.getElementById('searchValue').value;
        if(value){
            event.target.setAttribute('action',`${url}/search/${value}`);
            event.target.submit();
        }

    })

})