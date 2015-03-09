<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        @include('common.head', array('title', 'GradList - Find a Job') )
        {{ HTML::style('css/policy.css') }}
        {{ HTML::style('css/main.css') }}
        {{ HTML::style('css/base.css') }}
        {{ HTML::style('css/base_extended.css') }}
        {{ HTML::style('css/signup.css') }}
    </head>
    <body>
        <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <div id="topbar_bg">
            <div id="topbar">
                <a href="/"><div id="logo"></div></a>
                {{link_to_route('logout', 'Log Out', [], ['class' => 'login-header-btn'])}}
                {{link_to_route('profile.changePassword', 'Change Password', [], ['class' => 'login-header-btn'])}}
                <div id="spacer"></div>
            </div>
        </div>
        {{Form::model($user, ['method' => 'post', 'onsubmit' => 'return checkUpdateValidation();', 'route'=> ['user.update']])}}
            <div id="basic-edit-form">
               
               <div id="edit_profile_header">Profile Edit</div>
               
                <div id="activate_box">
                    <div class="box_header_with_subtitle">Contact frequency</div>
                    <p class="box_header_subtitle">How often would you like employers to contact you?</p>
                    <select id="emails_per_week" name="emails_per_week">
                        <option value="0" @if($user->contact_frequency == 0){{' selected="selected" ' }}@endif>As much as they want</option>
                        <option value="1" @if($user->contact_frequency == 1){{' selected="selected" ' }}@endif>Once a week</option>
                        <option value="2" @if($user->contact_frequency == 2){{' selected="selected" ' }}@endif>Once a month</option>
                    </select>
                    <p class="box_header_subtitle">Do you want to completely hide your profile from employers?</p>
                    <div id="search_criteria_specific">
                    <?php
                    $background_color_else = 'background-color: #fff;';
                    if($user->email_activity==1)
                    {
                        $background_color = 'background-color: #e74c3c;';
                    ?>
                        <a href="profile/status-on" id="profile-on">
                            <div id="left_search_tab" class="sr-selected" style="color:#fff;height:40px;{{$background_color}}">Yes</div>
                        </a>
                    <?php
                    }
                    else
                    {
                    ?>
                        <a href="profile/status-on" id="profile-on">
                            <div id="left_search_tab" class="sr-unselected" style="color: #7f8c8d;height:40px;{{$background_color_else}}">Yes</div>
                        </a>
                    <?php
                    }
                    if($user->email_activity==2)
                    {
                        $background_color = 'background-color: #2ecc71;';
                    ?>
                        <a href="profile/status-off" id="profile-off">
                            <div id="right_search_tab" class="sr-selected" style="color: #fff;height:40px;{{$background_color}}">No</div>
                        </a>
                    <?php
                    }
                    else
                    {
                    ?>
                        <a href="profile/status-off" id="profile-off">
                            <div id="right_search_tab" class="sr-unselected" style="color: #7f8c8d;height:40px;{{$background_color_else}}">No</div>
                        </a>
                    <?php
                    }
                    ?>
                    </div>
                </div>
                
                
                <div id="form_div_header">Basic details</div>
                <div id="personal_box">
                    <div class="text_input_container">
                        <div class="error_overlay" id="first_name_error">First name required</div>
                        {{Form::text('first_name', $user->first_name, ['id' => 'first_name_input', 'placeholder' => 'First Name'])}}
                    </div>
                    <div class="text_input_container">
                        <div class="error_overlay" id="last_name_error">Last name required</div>
                        {{Form::text('last_name', $user->last_name, ['id' => 'last_name_input', 'placeholder' => 'Last Name'])}}
                    </div>
                </div>
                <div id="form_div_header">Sector preferences</div>
                <div id="industry_interest_error" class="error_overlay_header">It's bit required, but this bit's useful to match you with employers.</div>       
                <div id="sector_box">
                    @include('profile.inputs.work', ['workOptions' => $workOptions, 'userOptions' => $userOptions])
                    <div id="spacer"></div>
                </div>
                <div id="industry_typeu_interest_error" class="error_overlay_header">Job Type is required field. Please choose any one of them.</div>
                <div id="job_type_box">
                    <div id="agnostic_box_header" class="sector_grouping_header">Job Type</div>
                    <div id="job_type_container">
                        @foreach ( $workTypes as $workType )
                        <?php $isChecked = in_array($workType->id, $userDesiredWorkType);
                            if($isChecked){
                                $checkedClass = 'checkbox_checked';
                                $checkedContainer = 'checkbox_container_selected';
                            }else{
                                $checkedClass = '';
                                $checkedContainer = '';
                            }
                            if($workType->approved == 0 && !$isChecked)
                                continue;
                        ?>
                        <div class="checkbox_container_option {{$checkedContainer}}">
                            <div class="checkbox_option {{$checkedClass}}">
                                {{Form::checkbox('desired_job_type[]', $workType->id, $isChecked, ['id' => 'desired_job_type-'.$workType->id, 'class' => $checkedClass])}}
                            </div>
                            <p class="{{$checkedClass}}">{{$workType->name}}</p>
                        </div>
                        @endforeach
                    </div>
                    <div id="agnostic_box_header" class="sector_grouping_header">Job Location</div>
                    <div id="industry_locationu_interest_error" class="error_overlay_header">Job Location is required field. Please choose any one of them.</div>
                    <div id="job_location_container">
                        @foreach($locations as $location)
                        <?php $isChecked = in_array($location->id, $userLocations);
                            if($isChecked){
                                $checkedClass = 'checkbox_checked';
                                $checkedContainer = 'checkbox_container_selected';
                            }else{
                                $checkedClass = '';
                                $checkedContainer = '';
                            }
                        ?>
                        <div class="checkbox_container_option {{$checkedContainer}}">
                            <div class="checkbox_option {{$checkedClass}}">
                                {{Form::checkbox('job_location[]', $location->id, $isChecked, ['class' => $checkedClass] )}}
                            </div>
                            <p class="{{$checkedClass}}">{{$location->name}}</p>
                        </div>
                        @endforeach
                    </div>
                    <div id="agnostic_box_header" class="sector_grouping_header">Availability</div>
                    <label class="availability_option">{{Form::radio('availability', 1, ($user->availability == 1), ['class' => 'radio_availability'])}}Immediately </label>
                    <label class="availability_option">{{Form::radio('availability', 2, ($user->availability == 2), ['class' => 'radio_availability'])}}This summer</label>
                    <label class="availability_option">{{Form::radio('availability', 'other', ($user->availability == 'other'), ['class' => 'radio_availability'])}}Other</label>
                    <?php
                    $avail_month_style = 'display: none;';
                    $availability_dates = explode("-",$user->availability_date);
                    if($user->availability == 'other')
                    {
                        $avail_month_style = 'display: block;';
                    }
                    $monthavailable_id = 'month_available';
                    if($availability_dates[1]!='00')
                    {
                        $monthavailable_id = 'months_available';
                    }
                    ?>
                    <div id="availability_other_details" style="<?php echo $avail_month_style; ?>">
                        <select name="availability_month" id="<?php echo $monthavailable_id; ?>">
                            <?php
                            for($i=1;$i<=12;$i++){
                            $month_val = sprintf("%02s", $i);
                            ?>
                            <option value="<?php echo $month_val;?>" <?php if($availability_dates[1] == $i){echo 'selected="selected"';}?>><?php echo date("F", mktime(0, 0, 0, $month_val));?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <select name="availability_year" id="degree_graduation">
                            <?php
                            $_current_year = date("Y");
                            $_next_year = $_current_year+4;
                            for($j=$_current_year;$j<=$_next_year;$j++)
                            {
                            ?>
                            <option value="<?php echo $j;?>" <?php if($availability_dates[0]==$j){echo 'selected="selected"';}?>><?php echo $j;?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <!--<div>
                        <label class="availability_option">{{Form::checkbox('not_want_to_move', 1, false, ['class' => 'radio_availability'])}}I am not looking to move right now</label>
                    </div>-->
                    <!--<div id="agnostic_box_header" class="sector_grouping_header">...Some text needed here...</div>
                    <?php $uPayment = $user->desired_payment;
                        if( $uPayment == 2 || $uPayment == 6 || $uPayment > 8 )
                            $equity = true;
                        else
                            $equity = false;
                        if( $uPayment == 4 || $uPayment == 6 || $uPayment == 12 )
                            $payed = true;
                        else
                            $payed = false;
                        if( $uPayment == 8 || $uPayment == 10 || $uPayment == 12 )
                            $unpayed = true;
                        else
                            $unpayed = false;
                    ?>
                    <label class="availability_option">{{Form::radio('desired_payment[]', 4, $payed, ['class' => 'radio_availability'])}}I am only interested in paid roles</label>
                    <label class="availability_option">{{Form::radio('desired_payment[]', 8, $unpayed, ['class' => 'radio_availability'])}}I am open to unpaid roles</label>
                    <label class="availability_option">{{Form::checkbox('desired_payment[]', 2, $equity, ['class' => 'radio_availability'])}}I am willing to consider equity in place of / alongside payment</label>--> 
                </div>
            </div>
                <!--  Second section start  -->
            <div id="education-edit-form">
                <div id="form_div_header">Education</div>
                <div id="education_container">
                    <div id="universityu_error" class="error_overlay_header">This bit's required</div>   
                    @foreach($user->university as $university)
                    <div id="uni_details_box"> 
                        <div id="box_header">
                            <div class="box_header">University</div>
                        </div>
                        <div class="delete_box_btn"></div>
                        @include('profile.inputs.degree_type_dropdown', ['degreeTypes'=> $degreeTypes, 'selectedId' => $university->type->id])
                        @include('profile.inputs.university_dropdown', ['universities'=> $universities, 'selectedId' => $university->university->id])
                        @include('profile.inputs.degree_subject_dropdown', ['degreeSubjects'=> $degreeSubjects, 'selectedId' => $university->subject->id])
                        <div id="uni_subject_container" class="text_input_container">
                            {{Form::text('degree_subject_name[]', $university->name, ['id' => 'uni_subject_name', 'placeholder' => 'Subject'])}}
                        </div>

                        <select name="degree_result[]" id="degree_result">
                            <option value="default">Result</option>
                            @foreach ( $degreeResults as $degreeResult )
                            @if($degreeResult->approved == 0 && $degreeResult->id != $university->result->id)
                                @continue
                            @endif;
                            <option value="{{ $degreeResult->id }}" @if($degreeResult->id == $university->result->id){{'selected="selected"'}}@endif>{{ $degreeResult->name }}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                        @include('profile.inputs.degree_graduation_dropdown', ['selectedId' => $university->degree_year])
                        {{Form::hidden('degree-id[]', $university->id)}}
                    </div>
                    @endforeach()
                </div>
                <div class="dark_grey_button" id="add_degree_button">Add Degree +</div>
                <div id="qualifications_container">
                    @foreach($user->schoolQualification as $school)
                    <div class="qual_box" id="qualifications_box">
                        <div id="school_error" class="error_overlay_header">It's up to you, but this bit matters to employers</div>
                        <div class="box_header">School</div>
                        <div class="delete_box_btn"></div>

                        @include('profile.inputs.school_qualification_types', ['schoolQualificationTypes' => $schoolQualificationTypes, 'selectedId' => $school->type->id])
                        <select name="qual_subject_type[]" id="qual_subject">
                            <option value="0">Subject Type</option>
                            @foreach($schoolOptions as $option)
                                {{$option->approved}} - {{$option->id}} - {{$school->school_subject_id}}
                                @if($option->approved == 0 && $option->id != $school->school_subject_id)
                                    @continue
                                @endif
                                <option value="{{$option->id}}" @if($option->id == $school->school_subject_id){{'selected="selected"'}}@endif>{{$option->name}}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>

                        <div id="qual_subject_container" class="text_input_container">
                        {{Form::text('qual_subject_name[]', $school->subject, ['id' => 'qual_subject_name', 'placeholder' => 'Subject'])}}
                        </div>
                        <select name="qual_result[]" id="qual_result">
                            @foreach($school->type->results as $_result)
                                <option value="{{$_result->id}}" @if($_result->id == $school->result->id){{'selected="selected"'}}@endif>{{$_result->name}}</option>
                            @endforeach
                            <option value="default">Result</option>
                            <option value="other">Other</option>
                        </select>
                        {{Form::hidden('school-id[]', $school->id)}}
                    </div>
                    @endforeach()
                </div>
                <div class="dark_grey_button" id="add_qualification_button">Add Qualification +</div>
                <div id="key_skills_container">
                    <div class="box_header">Skills</div>
                    <?php $_lastGroupId = 0;  $_isOpened = false; ?>
                    @foreach( $skills as $option )
                    <?php 
                        $isCkecked = isset($userSkills[$option->id]);
                        if($isCkecked == true)
                        {
                            $keySkillClass = 'skill_selected';
                            $skillContainerClass = 'checkbox_container_selected';
                            $skillCheckedClass = 'checkbox_checked';
                            $dropdownDisplay = 'block';
                        }else{
                            $keySkillClass = '';
                            $skillContainerClass = '';
                            $skillCheckedClass = '';
                            $dropdownDisplay = 'none';
                        }
                    ?>
                    @if( $option->skill_group->id != $_lastGroupId && $_lastGroupId != 0 )
                </div>
                    @endif 
                    @if( $option->skill_group->id != $_lastGroupId || $_lastGroupId == 0 )
                    <div class="skill_divider">{{ $option->skill_group->name }}</div>
                    <div class="sub_skill_container" style="display: none;">
                    @endif    
                       <div class="key_skill {{$keySkillClass}}">
                            <div class="checkbox_container_option {{$skillContainerClass}}">
                                <div class="checkbox_option {{$skillCheckedClass}}"></div>
                                <p class="{{$skillCheckedClass}}">{{ $option->name }}</p>
                                <input type="checkbox" name="skills[]" value="{{$option->id}}" class="{{$skillCheckedClass}}" <?php if($isCkecked==1) {echo 'checked="checked"';} ?> />
                            </div>
                           <select name="skill_levels[]" style="display: {{$dropdownDisplay}};">
                                <option value="0" @if(isset($userSkills[$option->id][1]) && $userSkills[$option->id][1] == 0){{'selected="selected"'}}@endif>Level</option>
                                <option value="1" @if(isset($userSkills[$option->id][1]) && $userSkills[$option->id][1] == 1){{'selected="selected"'}}@endif>Basic</option>
                                <option value="2" @if(isset($userSkills[$option->id][1]) && $userSkills[$option->id][1] == 2){{'selected="selected"'}}@endif>Intermediate</option>
                                <option value="3" @if(isset($userSkills[$option->id][1]) && $userSkills[$option->id][1] == 3){{'selected="selected"'}}@endif>Expert</option>
                            </select>
                        </div>
                    <?php $_lastGroupId = $option->skill_group->id; $_isOpened = true; ?>
                    @endforeach
                    @if( $_isOpened === true )
                        </div> 
                    @endif
                </div>
                <div id="capabilitiesu_container_error" class="error_overlay_header">This bit's required</div>
                <div id="capabilities_container">
                    <div class="box_header_with_subtitle">Capabilities</div>
                    <p class="box_header_subtitle">Select the <span id="capabilities_five">five</span> capabilities which best describe your core strengths</p>
                    @foreach($capabilites as $capability)
                    <?php $isChecked = in_array($capability->id, $userOptions);
                        if($isChecked){
                            $checkedClass = 'checkbox_checked';
                            $checkedContainer = 'checkbox_container_selected';
                        }else{
                            $checkedClass = '';
                            $checkedContainer = '';
                        }
                    ?>
                    <div class="checkbox_container_option {{$checkedContainer}}">
                        <div class="checkbox_option {{$checkedClass}}"></div>
                        <p class="{{$checkedClass}}">{{$capability->name}}</p>
                        {{Form::checkbox('capabilities[]', $capability->id, $isChecked, ['class' => $checkedClass])}}
                    </div>
                    @endforeach
                </div>
                <div id="form_div_header">Languages</div>
                <div id="english_language_container">
                    <div id="languages_box_english">
                        <div id="english_title">English</div>
                        <div id="english_language_error" class="error_overlay_header">This bit's required</div> 
                        <select name="english_level" id="english_level">
                            <option value="0">Select</option>
                            @foreach ( $languageLevels as $languageLevel )
                            <option value="{{ $languageLevel->id }}" @if($user->english_level == $languageLevel->id){{'selected="selected"'}}@endif>{{ $languageLevel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="second_language_container">
              
                @foreach($user->language as $userLang)
                    <div id="languages_box">
                        <!--<div id="english_title">English</div>-->
                        <select name="languages[]" id="languages">
                            <option value = "0">Language</option>
                            @foreach( $languages as $language )
                            @if($language->approved == 0 && $userLang->name_id != $language->id)
                                @continue
                            @endif
                            <option value="{{ $language->id }}" @if($userLang->name_id == $language->id){{' selected="selected" ' }}@endif>{{ $language->name }}</option>
                            @endforeach
                            <option value = "other">Other</option>
                        </select>

                        <select name="languages_level[]" id="languages_level">
                            <option value="0">Level</option>
                            @foreach ( $languageLevels as $languageLevel )
                            <option value="{{ $languageLevel->id }}" @if($userLang->level_id == $languageLevel->id){{' selected="selected" ' }}@endif>{{ $languageLevel->name }}</option>
                            @endforeach
                        </select>
                        <div class="delete_box_btn" style="display: block;"></div>
                        {{Form::hidden('language-id[]', $userLang->id)}}
                    </div>
                @endforeach
                </div>
                <div class="dark_grey_button" id="add_language_button">Add Language +</div>
            </div>
            <div id="experience-edit-form">
                <div id="form_div_header">Work Experience</div>
                <div id="work_experience_container">
                    @foreach($user->work as $userExperience)
                    <div id="work_experience_box">
                        <div id="work_experience_error" class="error_overlay_header">Something's missing here</div>
                        <div class="box_header">Work Experience</div>
                        <div class="delete_box_btn"></div>
                        <select name="work_type[]" id="work_type">
                            <option value="default">Type</option>
                            @foreach ( $workTypes as $workType )
                            <option value="{{ $workType->id }}" @if($workType->id == $userExperience->type->id){{'selected="selected"'}}@endif>{{ $workType->name }}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                        <select name="work_length[]" id="work_length">
                            <option value="0">Work Duration</option>
                            @foreach ( $workDurations as $workDuration )
                            <option value="{{ $workDuration->id }}" @if($workDuration->id == $userExperience->work_duration_id){{'selected="selected"'}}@endif>{{ $workDuration->name }}</option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>
                        <select id="work_sector_select" name="work_sector[]">
                            <option value="default">Job Sector</option>
                            <?php $_lastGroupId = 0;  $_isOpened = false; ?>
                            @foreach( $workOptions as $option )
                            @if( $option->group->id != $_lastGroupId && $_lastGroupId != 0 )
                                </optgroup>
                            @endif 
                            @if( $option->group->id != $_lastGroupId || $_lastGroupId == 0 )
                            <optgroup label="{{ $option->group->name }}">
                            @endif    
                                <option value="{{$option->id}}" @if($userExperience->sector->id == $option->id){{'selected="selected"'}}@endif>{{ $option->name }}</option>
                            <?php $_lastGroupId = $option->group->id; $_isOpened = true; ?>
                            @endforeach
                            @if( $_isOpened === true )
                                </optgroup>   
                            @endif
                        <option value="other">Other</option>
                        </select>
                        
                        <div class="text_input_container">
                            <div id="organisation_name_error"></div>
                            {{Form::text('work_organisation[]', $userExperience->name, ['placeholder' => 'Organisation', 'id' => 'work_organisation'])}}
                        </div>
                        {{Form::hidden('work-experience-id[]', $userExperience->id)}}
                    </div>
                    @endforeach
                </div>
                <div class="dark_grey_button" id="add_experience_button">Add Experience +</div>
                <div id="form_div_header">Extra-curricular</div>
                <div id="positions_container">
                    <div id="society_container">
                        <?php
                            if (isset($social->category->id))
                                $social_category_id = $social->category->id;
                            else
                                $social_category_id = 0;

                            if (isset($social->position->id))
                                $social_position_id = $social->position->id;
                            else
                                $social_position_id = 0;
                        ?>
                        @foreach($user->social as $social)
                        <div id="society_box">
                            <div id="work_experience_error" class="error_overlay_header">Something's missing here</div>
                            <div class="box_header">Society</div>
                            <div class="delete_box_btn"></div>
                                
                            @include('profile.inputs.social_categories_dropdown', ['socialCategories' => $socialCategories, 'selectedId' => $social_category_id])
                            @include('profile.inputs.social_positions_dropdown', ['socialPositions' => $socialPositions, 'selectedId' => $social_position_id])
                            <div class="text_input_container"> 
                                {{Form::text('society_name[]', $social->name, ['id' => 'society_name', 'placeholder' => 'Name'])}}
                            </div>
                            {{Form::hidden('social-id[]', $social->id)}}
                        </div>
                        @endforeach
                    </div>
                    <div class="dark_grey_button" id="add_society_button">Add Society +</div>
                    <div id="sport_container">
                        @foreach($user->sport as $sport)
                        <div id="sport_box">
                            <div id="work_experience_error" class="error_overlay_header">Something's missing here</div>
                            <div class="box_header">Sport</div>
                            <div class="delete_box_btn"></div>
                            <select name="sport_category[]" id="sport_category">
                                <option value="default">Sport</option>
                                @foreach ( $sportNames as $sportName )
                                @if($sportName->approved == 0 && $sportName->id != $sport->name->id)
                                    @continue
                                @endif
                                <option value="{{ $sportName->id }}" <?php echo (($sportName->id == $sport->name->id)?'selected="selected"':""); ?> >{{ $sportName->name }}</option>
                                @endforeach
                                <option value="other">Other</option>
                            </select>
                            <select id="sport_level" name="sport_level[]">
                                <option value="default">Level</option>
                                @foreach ( $sportLevels as $sportLevel )
                                @if($sportLevel->approved == 0 && $sportLevel->id != $sport->level->id)
                                    @continue
                                   @endif
                                <option value="{{ $sportLevel->id }}" @if($sportLevel->id == $sport->level->id){{'selected="selected"'}}@endif>{{ $sportLevel->name }}</option>
                                @endforeach
                                <option value="other">Other</option>
                            </select>
                            <select name="sport_position[]">
                                <option value="default">Position</option>
                                @foreach ( $sportPositions as $sportPosition )
                                @if($sportPosition->approved == 0 && $sportPosition->id != $sport->position->id)
                                    @continue
                                @endif
                                <option value="{{ $sportPosition->id }}" @if($sportPosition->id == $sport->position->id){{'selected="selected"'}}@endif>{{ $sportPosition->name }}</option>
                                @endforeach
                                <option value="other">Other</option>
                            </select>
                            {{Form::hidden('sport-id[]', $sport->id)}}
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="dark_grey_button" id="add_sport_button">Add Sport +</div>
            </div>
            <div id="other-edit-form">
            <div id="attributesu_container_error" class="error_overlay_header">Pleae choose atleast one attributes!</div>
            <div id="attributes_container">
                <div class="box_header_with_subtitle">Specific Experience</div>
                <p class="box_header_subtitle">Let employers know what you have experience of doing</p>
                @foreach($attributes as $attribute)
                <?php $isChecked = in_array($attribute->id, $userOptions);
                    if($isChecked){
                        $checkedClass = 'checkbox_checked';
                        $checkedContainer = 'checkbox_container_selected';
                    }else{
                        $checkedClass = '';
                        $checkedContainer = '';
                    }
                ?>
                <div class="checkbox_container_option {{$checkedContainer}}">
                    <div class="checkbox_option {{$checkedClass}}"></div>
                    <p class="{{$checkedClass}}">{{$attribute->name}}</p>
                    {{Form::checkbox('attributes[]', $attribute->id, $isChecked, ['class' => $checkedClass])}}
                </div>
                @endforeach
            </div>
            
            <div id="form_div_header">Just one or two more questions</div>
            <div id="other_personal_box">
                <div id="dob_allu_error" class="error_overlay_header">These fields are bit required!</div>
                <div id="dob_error" class="error_overlay_header">You must be over 18 to use GradList</div> 
    
                <select name="gender" id="gender">
                    <option value="1" @if($user->gender == 1){{' selected="selected" '}}@endif>Male</option>
                    <option value="2" @if($user->gender == 2){{' selected="selected" '}}@endif>Female</option>
                    <option value="0" @if($user->gender == 0){{' selected="selected" '}}@endif>Prefer Not to Say</option>
                </select>
                <select id="ethnicity" name="ethnicity">
                    <option value="0">Ethnicity</option>
                    <?php $_lastGroupId = 0;  $_isOpened = false; ?>
                    @foreach( $ethnicities as $ethnicity )
                    @if( $ethnicity->group_id != $_lastGroupId && $_lastGroupId != 0 )
                        </optgroup>
                    @endif 
                    @if( $ethnicity->group_id != $_lastGroupId || $_lastGroupId == 0 )
                    <optgroup label="{{ $ethnicity->group['name'] }}">
                    @endif    
                        <option value="{{$ethnicity->id}}" @if($ethnicity->id == $user->ethnicity_id){{' selected="selected" '}}@endif>{{ $ethnicity->name }}</option>
                    <?php $_lastGroupId = $ethnicity->group_id; $_isOpened = true; ?>
                    @endforeach
                    @if( $_isOpened === true )
                        </optgroup>   
                    @endif
                        <option value="other">Other</option>
                        <option value="0">Prefer Not to Say</option>
                </select>
                <div id="dob_title">Date of Birth</div>
                <div id="dob_inputs_container">
                    <select name="date_dob" id="date_dob">
                        @for( $i = 1; $i <= 31; $i++ )
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" @if(substr($user->dob, 8, 2) == $i){{' selected="selected" '}}@endif>{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="month_dob" id="month_dob">
                        <option value="01" @if(substr($user->dob, 5, 2) == '01'){{' selected '}}@endif>January</option>
                        <option value="02" @if(substr($user->dob, 5, 2) == '02'){{' selected '}}@endif>February</option>
                        <option value="03" @if(substr($user->dob, 5, 2) == '03'){{' selected '}}@endif>March</option>
                        <option value="04" @if(substr($user->dob, 5, 2) == '04'){{' selected '}}@endif>April</option>
                        <option value="05" @if(substr($user->dob, 5, 2) == '05'){{' selected '}}@endif>May</option>
                        <option value="06" @if(substr($user->dob, 5, 2) == '06'){{' selected '}}@endif>June</option>
                        <option value="07" @if(substr($user->dob, 5, 2) == '07'){{' selected '}}@endif>July</option>
                        <option value="08" @if(substr($user->dob, 5, 2) == '08'){{' selected '}}@endif>August</option>
                        <option value="09" @if(substr($user->dob, 5, 2) == '09'){{' selected '}}@endif>September</option>
                        <option value="10" @if(substr($user->dob, 5, 2) == '10'){{' selected '}}@endif>October</option>
                        <option value="11" @if(substr($user->dob, 5, 2) == '11'){{' selected '}}@endif>November</option>
                        <option value="12" @if(substr($user->dob, 5, 2) == '12'){{' selected '}}@endif>December</option>
                    </select>
    
                    <select name="year_dob" id="year_dob">
                        @for ($i = 2007; $i >= 1900; $i--)
                        <option value="{{ $i }}" @if(substr($user->dob, 0, 4) == $i){{' selected '}}@endif>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            
            
        </div>
                <!--  Second section end  -->
            <div id="button_holder" style="margin: auto;">
            {{Form::button('Save', ['id' => 'profile-update-btn', 'class' => 'red_button', 'style' => 'height: 42px;', 'type' => 'submit'])}}
            </div>
        {{Form::close()}}
<div id="spacer"></div>
<div id="footer"></div>
@include('common.bottom')
{{ HTML::script('/js/jquery-1.8.3.min.js') }}
{{ HTML::script('js/log_in.js') }}
{{ HTML::script('/js/plugins.js') }}
{{ HTML::script('/js/verimail.jquery.js') }}
{{ HTML::script('/js/main.js') }}
{{ HTML::script('/js/date.js') }}
{{ HTML::script('/js/jquery.ba-bbq.js') }}
{{ HTML::script('/js/sign_up.js') }}
{{ HTML::script('/js/jquery.html5-placeholder-shim.js') }}
<script>
var schoolQualificationResults =
    {
    @foreach($schoolQualificationTypes as $schoolQualificationType)
    '{{$schoolQualificationType->id}}': ''+
        @foreach($schoolQualificationType->results as $result)
            '<option value="{{$result->id}}">{{$result->name}}</option>'+
        @endforeach
            '<option value="other">Other</option>',
    @endforeach
    }

function checkUpdateValidation()
{

    var formError = true;
    var firstName = $('#first_name_input').val();
    var lastName = $('#last_name_input').val();
    if(firstName.search(/\S/)==-1)
    {
        $('#first_name_error').fadeIn();
        formError = false;
    }
    if(lastName.search(/\S/)==-1)
    {
        $('#last_name_error').fadeIn();
        formError = false;
    }
    if ($('#sector_box input:checkbox:checked').length == 0) {
        $("#industry_interest_error").fadeIn();
        formError = false;
    }
    if($('#job_type_container input:checkbox:checked').length == 0) {
        $("#industry_typeu_interest_error").fadeIn();
        formError = false;
    }
    if($('#job_location_container input:checkbox:checked').length == 0) {
        $("#industry_locationu_interest_error").fadeIn();
        formError = false;
    }
    $("#education_container select").each(function() {
        var selectValue = $(this).val();
        if (selectValue == "default" || selectValue == 0) {
            $(this).addClass("select_default_error");
            formError = false;
            $('#universityu_error').fadeIn();
        }
    });
    if($('#capabilities_container input:checkbox:checked').length == 0) {
        $("#capabilitiesu_container_error").fadeIn();
        formError = false;
    }
    if($('#attributes_container input:checkbox:checked').length == 0) {
        $("#attributesu_container_error").fadeIn();
        formError = false;
    }
    $("#other_personal_box select").each(function() {
        var selectValue = $(this).val();
        if (selectValue == "default" || selectValue == 0) {
            $(this).addClass("select_default_error");
            formError = false;
            $('#dob_allu_error').fadeIn();
        }
    });
    var birthDate = $("#month_dob").val() + " " + $("#date_dob").val() + " " + $("#year_dob").val();
    birthDateConverted = Date.parse(birthDate);
    eighteenYearsAgo = (18).years().ago();
    if (birthDateConverted <= eighteenYearsAgo) {
        $("#month_dob").removeClass("select_default_error");
        $("#date_dob").removeClass("select_default_error");
        $("#year_dob").removeClass("select_default_error");
        $("#dob_error").fadeOut();
    }
    else {
        $("#month_dob").addClass("select_default_error");
        $("#date_dob").addClass("select_default_error");
        $("#year_dob").addClass("select_default_error");
        formError = false;
        $("#dob_error").fadeIn();
    }
    
    
    if(formError==false)
    {
        $("html, body").animate({scrollTop: 0}, "slow");
    }
 
    return formError;
    
}
</script>
</body>
</html>