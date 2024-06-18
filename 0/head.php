<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" id="scale">
<meta property="og:title" content="HANU TESTS">
<meta property="og:url" content="">
<meta property="og:image" content="">
<meta property="og:description" content="HANU Tests">
<script src="/jquery.js"></script>
<style>
:root {
    --radius: 15px;
    --shadow: #aaa 0 0.5px 2px 0.25px;
    --light-gray: #f0f2f5;
    --light-yellow: #fbecd8;
    --light-red: #fde3df;
    --light-blue: #e3f4fe;
    --light-green: #e4fee9;
    --yellow: #ffe6c8;
    --red: #fbddd8;
    --blue: #d8eefb;
    --green: #d8fbdf;
    --gray: #65676b;
    --dark-blue: #004aac;
    --dark-yellow: #fac586;
    --dark-red: #c9072a;
    --black-blue: #45628c;
    --link-blue: #004eff;
    --button-gray: #f2f2f2;
}
body {
    margin: 0;
    font-family: system-ui;
    background-color: var(--light-gray);
}
*:focus-visible {
    outline: none;
}
/*------------------------------------*/
#warn {
    display: none;
    flex-direction: column;
    align-items: center;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 12;
    background-color: white;
    padding: 10px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}
#warn>h3 {
    margin: 10px;
    color: var(--dark-blue);
}
#warn>button {
    padding: 5px 15px;
    border: solid 1px #3b3b3b;
    border-radius: 7px;
    margin: 10px;
    background-color: var(--light-yellow);
    font-weight: bold;
}
#warn>button:hover {
    background-color: var(--yellow);
    cursor: pointer;
}
#warn+div {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgb(0 0 0 / 69%);
    z-index: 11;
}
/*------------------------------------*/
.loader {
    border: 16px solid #e8e7e7;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 40px;
    height: 40px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}
@-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
/*------------------------------------*/
nav {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 10;
    width: calc(100% - 30px);
    height: 30px;
    padding: 15px;
    box-shadow: #aaa 0 0 5px 1px;
    background-color: white;
}
nav>div>a {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 85px;
    height: 40px;
    border-radius: 5px;
}
nav>div>a:hover {
    background-color: var(--button-gray);
    cursor: pointer;
}
nav>div {
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    align-items: center;
}
nav>div:nth-child(2) {
    min-width: 50%;
}
#acc {
    width: 43px;
    border-radius: 5px;
    background-color: white;
    border: 0;
    padding: 15px 0;
}
#acc img {
    height: 30px;
    border-radius: 50%;
}
#acc ul {
    display: none;
    list-style-type: none;
    padding: 0;
    margin: 0;
    position: absolute;
    top: 60px;
    right: 15px;
    background-color: var(--light-green);
    border-radius: 10px;
    box-shadow: #aaa 0 1px 2px 0.5px;
}
#acc li {
    margin: 10px 20px;
}
#acc a {
    text-decoration: none;
    color: black;
    font-size: 115%;
    border-radius: 10px;
}
#acc a:hover {
    text-decoration: underline;
}
nav img+div {
    position: relative;
    bottom: -16px;
    height: 3px;
    width: 100%;
    background-color: #1B78F2;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
/*------------------------------------*/
nav+* {
    overflow: overlay;
    height: calc(100vh - 70px);
    padding-top: 10px;
}
/* width */
nav+*::-webkit-scrollbar {
    width: 5px;
    height: 0;
}
/* Track */
nav+*::-webkit-scrollbar-track {
    background: transparent;
} 
/* Handle */
nav+*::-webkit-scrollbar-thumb {
    background: transparent; 
    border-radius: 5px;
}
nav+*::-webkit-scrollbar-thumb:hover {
    background: #8EBED4;
}
/*------------------------------------*/
@media only screen and (max-width: 700px) {

nav>div:nth-child(2)>a {
    width: 60px;
    margin: 0 5px;
}

}
</style>