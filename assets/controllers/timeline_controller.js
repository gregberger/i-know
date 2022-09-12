import { Controller } from '@hotwired/stimulus';
import {Timeline} from "@knight-lab/timelinejs";

export default class extends Controller {
    static values = {
        dataUrl: String
    }

    connect() {
        this.getTimelineData()
            .then((resp)=> resp.json())
            .then((timelineData) => {
                let timeline = new Timeline(this.element, timelineData,
                    {
                        "scale_factor": 0.4,
                        "timenav_height_percentage": 30,
                        "hash_bookmark": true
                    }
                );
            });
        }
    async getTimelineData(){
        return await fetch(this.dataUrlValue);
    }
}
