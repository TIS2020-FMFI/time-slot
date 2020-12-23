/**
 * Time_slot je hlavna trieda ktora uchovava data o vstkych existujucich time_slots ktore su stiahnute
 * pomocou ajax requestou na adresi(../load_all_time_slots.php)
 */
class Time_slot {
    constructor() {
        this.ids = [];
        this.start_times = [];
        this.end_times = [];
        this.states = [];
        this.kamionists_1 = [];
        this.kamionists_2 = [];
        this.external_dispatchers = [];
        this.evcs = [];
        this.destinations = [];
        this.commoditys = [];
    }
    get_ids(){
        return this.ids;
    }
    get_start_times(){
        return this.start_times;
    }
    get_end_times(){
        return this.end_times;
    }
    get_states(){
        return this.states;
    }

    /**
     * pomocna funkcia pre vytvarianie HTML pre interneho dispatchera
     * pouzitie na adrese internal_dispatcher.js.global_calendar
     * @param state can be one of ['prepared','requested','booked','finished'] : string
     * @returns {number}
     */
    count_of_states(state){
        let count = 0;
        for (let i = 0;i < this.states.length;i++){
            if (state === this.states[i]){
                count ++;
            }
        }
        return count;
    }
    get_all_time_slots(){
        return [this.ids,this.start_times,this.end_times,this.states,this.evcs,this.kamionists_1,this.kamionists_2]
    }

    /**
     * format priadavanie do arrays pre EXD pri parseri dat vystup s ajax requestu
     * @param id :integer
     * @param s_time :string
     * @param e_time :string
     * @param state one of ['prepared','requested','booked','finished'] :string/null
     * @param evc :string/null
     * @param driver1 :string/null
     * @param driver2 :string/null
     * @param destination :string/null
     * @param commodity :string/null
     */
    add_next_time_slot_for_external_dispatcher(id, s_time, e_time, state,evc,driver1,driver2,destination,commodity){
        this.ids.push(id)
        this.start_times.push(s_time)
        this.end_times.push(e_time)
        this.states.push(state)
        this.evcs.push(evc)
        this.kamionists_1.push(driver1)
        this.kamionists_2.push(driver2)
        this.destinations.push(destination)
        this.commoditys.push(commodity)
    }

    /**
     * format priadavanie do arrays pre EXD pri parseri dat vystup s ajax requestu
     * @param id :integer
     * @param s_time :string
     * @param e_time :string
     * @param state one of ['prepared','requested','booked','finished'] :string/null
     * @param evc :string/null
     * @param employee :string/null
     * @param destination :string/null
     * @param commodity :string/null
     */
    add_next_time_slot_for_internal_dispatcher(id, s_time, e_time, state,evc,employee,destination,commodity){
        this.ids.push(id)
        this.start_times.push(s_time)
        this.end_times.push(e_time)
        this.states.push(state)
        this.evcs.push(evc)
        this.external_dispatchers.push(employee)
        this.destinations.push(destination)
        this.commoditys.push(commodity)
    }
    /**
     * format priadavanie do arrays pre EXD pri parseri dat vystup s ajax requestu
     * @param id :integer
     * @param s_time :string
     * @param evc :string/null
     * @param driver1 :string
     * @param driver2 :string/null
     * @param destination :string/null
     * @param commodity :string/null
     */
    add_next_time_slot_for_gate_man(id, s_time,evc,driver1,driver2,destination,commodity){
        this.ids.push(id)
        this.start_times.push(s_time)
        this.evcs.push(evc)
        this.kamionists_1.push(driver1)
        this.kamionists_2.push(driver2)
        this.destinations.push(destination)
        this.commoditys.push(commodity)
    }

    static open_time_slot(id,state) {
        console.log(id,state)
        $.post('order_AJAX/open_time_slot.php',{
            id:id,
            state:state,
        },function(data){
            console.log(data);
            if (data === '1'){
                window.open("order.php","_self");
            }else if (data === '2'){
                console.log("chybne sql");
            }else if (data === '3'){
                console.log('uz mas aktivni time slot prosim skuste zatvorit objednavku');
                //  alert("chyba v procese ");
            }
        });
    }
}