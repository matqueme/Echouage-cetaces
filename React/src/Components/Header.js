import "./CSS/Header.css"
import logostat from '../stats.png'

const Header = () => (
    <div className="header">
        <div id='headerLeft'><img src={logostat} alt="logo stat" /></div>
        <div id='headerCenter'>Mini projet - Echouages</div>
        <div id='headerRight'>2022</div>
    </div>
);


export default Header;