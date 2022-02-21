let url = 'http://127.0.0.1:8000'

window.addEventListener('load', () => {

    const buttons = document.querySelectorAll('.heart');
    const likesNumber = document.querySelectorAll('.likes-number');

    buttons.forEach((button, index) => {
        button.addEventListener('click', async () => {
            if (button.classList.contains('btn-like')) {


                try {
                    
                    const res = await axios.get(`${url}/dislike/${button.dataset.id}/${button.dataset.number}`);
                    if (res.data.like) {
                        const likeNumber = likesNumber[index];
                        button.classList.replace('btn-like','btn-dislike');
                        button.setAttribute('src',`${url}/img/heart.png`);
                        button.setAttribute('data-number', res.data.likeNumber);
                        likeNumber.innerHTML = res.data.likeNumber;
                    }

                } catch (error) {
                    console.log(error);
                }


            }else{

                try {
                    
                    const res = await axios.get(`${url}/like/${button.dataset.id}/${button.dataset.number}`);
                    if (res.data.like) {
                        const likeNumber = likesNumber[index];
                        button.classList.replace('btn-dislike','btn-like');
                        button.setAttribute('src',`${url}/img/heart-red.png`)
                        button.setAttribute('data-number', res.data.likeNumber);
                        likeNumber.innerHTML = res.data.likeNumber;
                    }

                } catch (error) {
                    console.log(error);
                }
            }

        })
    })

    const searchForm = document.getElementById('searchForm');

    searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const value = document.getElementById('searchValue').value;
        if (value) {
            event.target.setAttribute('action', `${url}/search/${value}`);
            event.target.submit();
        }

    })

})
