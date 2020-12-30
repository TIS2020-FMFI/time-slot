/**
 * Class Gate sluzi ako pristupova metoda k vstkim calendarom to znamena
 * Ramp_number 1  == Calendar[0]
 * ids sluzi na prechadzanie vytvorenich calendarou kedze
 * Ramp_number v DB nemusi byt usporiadane spravne 1,2,3 ale mozne byt 3,2,1
 * Gate -> Calendar.array_of_calendars -> Time_slot
 */
class Gate {
    constructor() {
        this.ids = [];
        this.array_of_calendars = [];//new Calendar();
    }
    get_ids(){
        return this.ids;
    }
    get_calendar(){
        return this.array_of_calendars;
    }
    push_calendar_and_id(id,calendar){
        this.ids.push(id);
        this.array_of_calendars.push(calendar);
    }
    contains_calendar(calendar){
        return this.array_of_calendars.includes(calendar);
    }

    /**
     * funkcia na zistenie existenicie ID == Ramp_number
     * @param id vstupni parameter :integer
     * @returns {boolean}
     */
    contains_id(id){
        return this.ids.includes(id);
    }

    /**
     * pokial sa hlada specificka rampa nieje nutne forbit
     * for cicle na miesta iba si vypitas index == Ramp_number
     * @param id
     * @returns {number}
     */
    get_index_by_id(id){
        return this.ids.indexOf(id);
    }

    // get_all_real_times_between(from,to){
    //     for (let i = 0;i < this.array_of_calendars.length;i++){
    //
    //     }
    // }
}