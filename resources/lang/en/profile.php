<?php

return [
// Tab title
    "TabTitle" => "Your profile",

// List normal words
    "BtnSave" => "Save" ,
    "BtnClose" => "Close",

// Master alert List
    "AlertSuccess" => "Complete!",
    "AlertError" => "Something went wrong!",

// Set Lang Validate
    "AlertLangNull" => "Please select language!",

//set token validate
    "ValidateToken" => "Token is invalid !" ,
    "LosingToken" => "Can't get token. Please try again" ,

// set controller msg
    "ValidatepublicMSGFail" => "Something went wrong. please try again later!",
    "VliadatepublicMSGSuccess" => "Public profile success",
    "ReturnResetComplete" => "Reset profile complete!!",
    "ReturnResetFail" => "Can't reset data! Please try again",

// Tab Menu
    "PublicProfile" => "Public profile",
    "ResetProfile" => "Reset profile" ,
    "MenuCustomBG" => "Custom Background",
    "MenuChangeLang" => "Change to thai",
    "MenuAbout" => "About",
    "MenuExperience" => "Experience",
    "MenuEducation" => "Education",
    "MenuPortfolio" => "Portfolio",
    "MenuSkill" => "Skills",
    "MenuAward" => "Certificate",

// modal zone
    /*[ Set language ]*/
    "SetLangHeader" => "Set profile language",
    "SetLangLabel" => "Please select your profile language." ,

    /* [ option language list ] */
    "OptionList" => "Please select language",
    "OptionListT" => "Thai",
    "OptionListE" => "English",
    "OptionListA" => "All (Thai and English)",

    /*[menu label]*/
    "EditLabel" => "Click for edit",

// About page
    /* add Address */
    "MenuAddAddress" => "Add your address",
    "SocialAccount" => "Social account" ,
    "NonAssignabout" => "Description not assign",

    // Modal
    "ModaladdrHeader" => "Set your address",
    "ModalPVBody" => "Province : ",
    "ModalDTBody" => "District : ",
    "ModalSTBody" => "Sub-District : ",
    "ModalZipCodeBody" => "Zip code : ",

    // select option
    "SelectProvinceLabel" => "Select Province" ,
    "SelectDistrictLabel" => "Select District" ,
    "SelectSubDistrictLabel" => "Select Sub-District",

    // validate form
    "ValidProvince" => "Please select Province!",
    "ValidDistrict" => "Please select District!",
    "ValidSubDistrict" => "Please select Sub-District",

    // Message from controller
    "MsgReturnError" => "Can't update your address!",
    "MsgReturnSuccess" => "Update your address complete!",

    /* Add about menu */

    // Label
    "AboutLabel" => "Add your description" ,

    // Modal
    "ModalAboutHeader" => "Set your description",
    "ModalAboutLabel_th" => "Your description (thai)",
    "ModalAboutLabel_en" => "Your description (eng)",
    "ModalPlaceHolder_th" => "ตัวอย่างเช่น : #โปรแกรมเมอร์ #ดาต้าเอ็นจิเนียร์",
    "ModalPlaceHolder_en" => "Example : #Programmer #DataEngineer",

    // Js Validate form
    "ErrJsAboutTH" => "Please enter your description (thai)" ,
    "ErrJsAboutEN" => "Please enter your description (eng)" ,
    "ErrJsOther" => "Somethings went wrong. Please contact administrator" ,

    // Controller return msg
    "ErrControllerMsg" => "Please Enter data in form!",
    "MsgCompleteAbout" => "Update your description complete" ,
    "MsgErrorAbout" => "Can't update your about!" ,

    /* Add Social list */

    // Label

    // Modal
    "ModalSocialHeader" => "Set your social account",
    "ModalOptionSocial" => "Social type : ",
    "ModalUrlSocial" => "Account URL : ",

    // Js Validate form
    "JsValidateSocialOption" => "Please select social account type!",
    "JsValidateSocialUrl" => "Please enter your link profile!",

    // Controller return msg
    "MsgDuplicateSocial" => "This social account is already exist!",
    "MsgCompleteSocial" => "Add your Social account complete" ,
    "MsgErrorSocial" => "Can't update your social account!" ,

// Work Experience Page

    // Render page
    "WorkEndDateRender" => "Present",

    // modal label
    "ModalWorkHeader" => "Add work experience" ,
    "label_ModalOfficeNameTh" => "Office name (thai) :" ,
    "label_ModalOfficeNameEN" => "Office name (eng) :" ,
    "label_ModalStartDate" => "Start date (MM/DD/YYYY) : " ,
    "label_ModalEndDate" => "Leaving date (MM/DD/YYYY) : " ,
    "label_ModalCheckRetireFlag" => "Still working" ,
    "label_ModalPositionNameTH" => "Position (thai) : " ,
    "label_ModalPositionNameEN" => "Position (eng) : " ,
    "label_ModalAboutTH" => "Work description (thai) : " ,
    "label_ModalAboutEN" => "Work description (eng) : " ,

    /*Place holder text*/
    "place_About" => "Describe the work involved." ,

    /*JsValidateText*/
    "Js_Workerror" => "An error occurred in the recording system. Please contact the administrator!",
    "Js_officeName_require" => "Please enter your office name" ,
    "Js_Recheck_workDate" => "Please Re-check your work start date and Leaving date" ,
    "Js_position_require" => "Please enter your position!" ,
    "Js_About_require" => "Please enter your work description!" ,

// Education page

    // Render page
    "GPALabel" => "GPA",

    // modal label
    "ModalEducateHeader" => "Add education" ,
    "ModalEducateLevel" => "Education level" ,
    "ModalEducateOption" => "Select education level" ,
    "ModalCollegeNameTH" => "College name (thai)" ,
    "ModalCollegeNameEN" => "College name (eng)" ,
    "ModalFacultyNameTH" => "Faculty name (thai)" ,
    "ModalFacultyNameEN" => "Faculty name (eng)" ,
    "ModalGpaValue" => "GPA" ,
    "ModalStartDate" => "Start date (MM/DD/YYYY)" ,
    "ModalEndDate" => "Leaving date (MM/DD/YYYY)" ,
    "ModalCheckLeavingFlag" => "Still educate" ,

    // JsValidate
    "Js_learning_type" => "Please select Education level" ,
    "Js_college_name" => "Please enter college name" ,
    "Js_faculty_name" => "Please enter faculty name" ,
    "Js_GpaValue" => "Your GPA value is invalid. Please try again!",
    "Js_start_date" => "Please enter start date" ,
    "Js_end_date" => "Please enter Leave date" ,
    "Js_recheck_date" => "Please Re-check start date and leave date" ,

    // Controller return msg
    "ctl_learning_list_req" => "Please select Education level" ,

    "ctl_college_name_th_req" => "Please enter your college name (thai)!",
    "ctl_college_name_th_max" => "Your college name (thai) is too long!",
    "ctl_college_name_th_min" => "Your college name (thai) is too short!",

    "ctl_college_name_en_req" => "Please enter your college name (eng)!",
    "ctl_college_name_en_max" => "Your college name (eng) is too long!",
    "ctl_college_name_en_min" => "Your college name (eng) is too short!",

    "ctl_faculty_name_th_req" => "Please enter your faculty name (thai)!",
    "ctl_faculty_name_th_max" => "Your faculty name (thai) is too long!",
    "ctl_faculty_name_th_min" => "Your faculty name (thai) is too short!",

    "ctl_faculty_name_en_req" => "Please enter your faculty name (eng)!",
    "ctl_faculty_name_en_max" => "Your faculty name (eng) is too long!",
    "ctl_faculty_name_en_min" => "Your faculty name (eng) is too short!",

    "ctl_gpa_value_req" => "Please enter your gpa value",

    "ctl_str" => "Only characters are allowed!",
    "msg_error_return" => "Can't insert education hist. Please try again later!" ,
    "msg_success_return" => "Insert education hist complete!",

// Portfolio page

    // render page
    "PortfolioViewImageLabel" => "View images" ,

    // modal form page
    "md_PortfolioHeader" => "Add Portfolio" ,
    "md_PortfolioNameTH" => "Portfolio name (thai) : ",
    "md_PortfolioNameEN" => "Portfolio name (eng) : ",
    "md_PortfolioDescTH" => "Portfolio description (thai) : ",
    "md_PortfolioDescEN" => "Portfolio description (eng) : ",
    "md_PortfolioTag" => "Portfolio Tag : " ,
    "md_PortfolioImages" => "Portfolio Images : " ,
    "md_PortfolioImageList" => "Portfolio Images list",

    "md_ph_port_name_th" => "Ex : ระบบสร้างโปรไฟล์" ,
    "md_ph_port_name_en" => "Ex : Gen profile system " ,
    "md_ph_port_desc_th" => "Ex : เป็นระบบที่จัดทำขึ้นเพื่อใช้ในการสร้างโปรไฟล์ของผู้ใช้งาน" ,
    "md_ph_port_desc_en" => "Ex : The system prepared for use in creating user profiles.",
    "md_ph_port_tag" => "Ex : #Programmer , #WebDev" ,

    // Jsvalidate
    "js_validate_port_name" => "Please enter portfolio name" ,
    "js_validate_port_desc" => "Please enter portfolio description" ,
    "js_validate_port_tag" => "Please enter portfolio tag" ,
    "js_validate_port_img_req" => "Please upload your portfolio photos" ,
    "js_validate_port_img_max" => "Maximum photos limit at 5 photo",
    "js_file_count_true" => "Your files : " ,
    "js_file_text" => "file" ,

    // controller return msg
    "ctl_msg_port_name_th_req" => "Please enter the portfolio name (Thai)" ,
    "ctl_msg_port_name_en_req" => "Please enter the portfolio name (English)." ,
    "ctl_msg_port_desc_th_req" => "Please enter the portfolio decription (Thai)" ,
    "ctl_msg_port_desc_en_req" => "Please enter the portfolio decription (English).",
    "ctl_msg_port_tag_req" => "Please enter the tag of the portfolio.",
    "ctl_msg_port_images_req" => "Please upload pictures of portfolio",
    "ctl_msg_image_type" => "Only support image files",
    "ctl_msg_mimes" => "Just allow extension files [jpeg , png , jpg , svg] only",

    "ctl_msg_port_success" => "Save the portfolio complete",
    "ctl_msg_port_fail" => "Can't save the portfolio. Please try again.",

// Certificate page

    // render page

    // modal form page
    "md_header_cert" => "Add Certificate and achievements" ,
    "md_cert_name_th_label" => "Certificate name (thai) : " ,
    "md_cert_name_en_label" => "Certificate name (eng) : " ,
    "md_cert_desc_th_label" => "Certificate description (thai) : ",
    "md_cert_desc_en_label" => "Certificate description (eng) : ",
    "md_cert_get_date" => "Certificate date : " ,
    "md_cert_images" => "Certificate images : " ,
    "md_cert_image_text" => "Upload your images" ,
    "md_cert_image_show" => "Certificate image" ,

    // form input data placeholder
    "md_ph_name_th" => "Ex : ใบรับรองการเป็นสมาชิกระบบสร้างโปรไฟล์",
    "md_ph_name_en" => "Ex : Profile Creation Membership Certificate.",
    "md_ph_desc_th" => "Ex : พูดเกี่ยวกับใบรับรองและรางวัลของคุณ" ,
    "md_ph_desc_en" => "Ex : Say about your certificate and achievements." ,

    // Jsvalidate
    "js_cert_name_th" => "Please enter your certificate name (thai)!",
    "js_cert_name_en" => "Please enter your certificate name (eng)",
    "js_cert_desc" => "Please enter your certificate description" ,
    "js_cert_images" => "Please enter your certificate images",
    "js_cert_max_image" => "Maximum photos limit at 2 photo",
    "js_cert_date" => "Please select certificate date" ,
    "js_cert_max_date" => "The date on the certificate is not valid",

    // controller return msg
    "ctl_cert_max_valid" => "Your description is too long",
    "ctl_cert_desc_th" => "Please enter your certificate description (thai)" ,
    "ctl_cert_desc_en" => "Please enter your certificate description (eng)" ,
    "ctl_msg_cert_fail" => "Can't save the certificate. Please try again.",
    "ctl_msg_cert_success" => "Save the certificate complete",

// Reset Profile Js Validate
    "js_reset_header" => "Are you sure to reset profile?",
    "js_reset_body" => "You can't cancel this process if you click button 'OK'",

// Public pprofile Js validate
    "js_public_header" => "Are you sure to public profile?",
    "js_public_body" => "Another user can view your profile",
];
