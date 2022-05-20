import React, { useState } from 'react'
import styles from '../mystyle.module.css';
import plus from '../image/plus.png'
import minus from '../image/minus.png'
import songimg from '../image/songimg.png'

export default function Song(props) {
    const [show, setshow] = useState(false);
    return (
        <>
            {show ?
                <div className={styles.songinfo}>
                    <button className={styles.btn}>
                        <img className={styles.logoimg} src={plus} alt="img" />
                    </button>
                    <img className={styles.img} src={songimg} alt="img" />
                    <button className={styles.btn}>
                        <img className={styles.logoimg} src={minus} alt="img" />
                    </button>
                </div> : null}

            <div onClick={() => setshow(!show)} className={styles.song}>
                <p>{props.songname}</p>
                <p className={styles.numbertext}>{props.songnumber}</p>
            </div>
        </>
    )
}
