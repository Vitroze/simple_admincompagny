.navbar {
    display: flex;
    flex-direction: column;
    width: 250px;
    height: 90vh;
    background-color: var(--white);
    padding: 20px;
}

.navbar li {
    list-style: none;
    margin-bottom: 20px;
}

.navbar a {
    display: flex;
    align-items: center;
    color: var(--text-dark);
    text-decoration: none;
    font-size: 16px;
    padding: 10px 15px;
    border-radius: 8px;
    transition: var(--transition);
}

.navbar a:hover {
    background-color: var(--primary-dark);
    color: var(--white);
}

.navbar i {
    margin-right: 10px;
    font-size: 18px;
}