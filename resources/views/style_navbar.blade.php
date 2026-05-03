.users {
    display: flex;
    align-items: center;
    background-color: var(--white);
    padding: 20px;
    width: 250px;
    border-radius: 8px;
}

.users a {
    width: 100%;
}

.navbar {
    display: flex;
    flex-direction: column;
    width: 250px;
    height: 75vh;
    background-color: var(--white);
    padding: 20px;
}

.navbar li, .users li {
    list-style: none;
    margin-bottom: 20px;
}

.navbar a, .users a {
    display: flex;
    align-items: center;
    color: var(--text-dark);
    text-decoration: none;
    font-size: 16px;
    padding: 10px 15px;
    border-radius: 8px;
    transition: var(--transition);
}

.navbar a:hover, .users a:hover {
    background-color: var(--primary-dark);
    color: var(--white);
}

.navbar i, .users i {
    margin-right: 10px;
    font-size: 18px;
}