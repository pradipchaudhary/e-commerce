 <!-- Side Filter -->
 <div class="col-md-3">
     <div class="side_filter" id="rootfilter">
         <div class="heading">
             <h4>Filter</h4>
             <a class="filter-clear" v-on:click="clearAll()">Clear all</a>
         </div>

         <div class="filter_group">
             <h4 class="filter_group_name">Lock Status </h4>
             <div class="filter_body" id="root" v-for="(status,key) in statuses">
                 <input type="checkbox" v-model="data.status_id" name="status_id" :value="status.id"
                     v-on:change="fliterData($event)">
                 @{{ status.name }} (@{{ status.statusCount }}) <br>
             </div>
         </div>

         <div class="filter_group">
             <h4 class="filter_group_name">Manufacturers </h4>
             <div class="filter_body" v-for="(manufacturer ,key) in manufacturers">
                 <input type="checkbox" :value="manufacturer.id" name="manufacturer_id" v-model="data.manufacturer_id"
                     class="mx-1 my-1" v-on:change="fliterData($event)">@{{ manufacturer.name }}
                 (@{{ manufacturer.manufacturerCount }})<br>
             </div>
         </div>

         <div class="filter_group">
             <h4 class="filter_group_name">Grades </h4>
             <div class="filter_subgroup">
                 <h5 class="sub_filter_group_title"> Primary </h5>
                 <div class="filter_body" v-for="(primary_grade,key) in primary_grades">
                     <input type="checkbox" :value="primary_grade.id" v-model="data.grading_scale_id"
                         class="mx-1 my-1" v-on:change="fliterData($event)">@{{ primary_grade.name + " -STOCK" }}
                     (@{{ primary_grade.gardeScaleCount }})
                     <br>
                 </div>
             </div>
             <div class="filter_subgroup">
                 <h5 class="sub_filter_group_title"> Secondary </h5>
                 <div class="filter_body" v-for="(secondary_grade,key) in secondary_grades">
                     <input type="checkbox" :value="secondary_grade.id" v-model="data.grading_scale_id"
                         class="mx-1 my-1" v-on:change="fliterData($event)">@{{ secondary_grade.name + " -STOCK" }}
                     (@{{ secondary_grade.gardeScaleCount }})
                     <br>
                 </div>
             </div>
         </div>


     </div>
 </div>
