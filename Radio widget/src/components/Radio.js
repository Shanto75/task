import React, {useState} from 'react'
import styles from '../mystyle.module.css';
import Song from './Song';
import backarrow from '../image/back-arrow.png'
import switchpng from '../image/switch.png'

function Radio(props) {
    function setsong(songname){
        setname(songname);
    }

    const [name, setname] = useState('');
    return (
        <>
            <div className={styles.box}>
                <div className={styles.header}>
                    <button className={styles.btn}><img src={backarrow} alt="" /></button>
                    <h1>{props.title}</h1>
                    <button className={styles.btn}><img src={switchpng} alt="" /></button>
                </div>

                <button onClick={()=>setsong('Putin FM')} className={styles.btn}><Song songname="Putin FM" songnumber="66,6" /></button><br />
                <button onClick={()=>setsong('Dribbble FM')} className={styles.btn}><Song songname="Dribbble FM" songnumber="101,2" /></button>
                <button onClick={()=>setsong('Doge FM')} className={styles.btn}><Song songname="Doge FM" songnumber="99,4" /></button>
                <button onClick={()=>setsong('Ballads FM')} className={styles.btn}><Song songname="Ballads FM" songnumber="87,1" /></button>
                <button onClick={()=>setsong('Maximum FM')} className={styles.btn}><Song songname="Maximum FM" songnumber="142,2" /></button>
                <div className={styles.footer}>
                    {
                    name?
                    <div>
                        <p>CURRENTLY PLAYING</p>
                        <h4>{name}</h4>
                    </div>
                    :null}
                </div>
            </div>
        </>
    )
}

export default Radio
