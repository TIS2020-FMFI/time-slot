/**
 * Calendar sluzi ako uschovna vsetkych Time_slot v premenenj 'time_slots'
 * premena 'real_times' sluzi ako spojovnik na vyhladavanie medzi Time_slots,
 * zaroven umoznuje hladanie vramici mini_calendaru vo formate 12-11-2020 (sk, DD:MM:YYYY) / 2020-12-11 (eng, YYYY:DD:MM)
 */
class Calendar {
    constructor() {
        this.real_times = [];
        this.time_slots = [];//new Time_slot();

    }
    get_real_times(){
        return this.real_times;
    }
    get_time_slots(){
        return this.time_slots;
    }
    push_real_time_and_time_slot(time,time_slot){
        this.real_times.push(time);
        this.time_slots.push(time_slot);
    }

    /**
     * funckia na vyhladanie po kliknuti na minicalenar / sipky
     * @param time format 12-11-2020 (sk, DD:MM:YYYY) / 2020-12-11 (eng, YYYY:DD:MM) : string
     * @returns {number}
     */
    get_index_by_real_time(time){
        return this.real_times.indexOf(time);
    }

}