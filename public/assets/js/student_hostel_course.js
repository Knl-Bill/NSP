
        var courseObject = 
        {
        "B.Tech.": ["Computer Science and Engineering", "Electronics and Communication Engineering", "Electrical Engineering", "Civil Engineering", "Mechanical Engineering"],
        "M.Tech.": ["Computer Science and Engineering", "Electronics and Communication Engineering", "Electrical Engineering", "Civil Engineering", "Mechanical Engineering"],
        "B.Sc.": ["Physics", "Chemistry", "Mathematics"],
        "M.Sc.": ["Physics", "Chemistry", "Mathematics"],
        "PhD": ["Physics", "Chemistry", "Mathematics", "Computer Science", "Electronics and Communication", "Electrical", "Civil", "Mechanical", "Humanities"]
        }

        var hostelData = {
            "Bharani Hostel": { floors: 4, rooms: 43 },
            "Bhavani Hostel": { floors: 2, rooms: 43 },
            "Moyar Hostel": { blocks: 10, rooms: 8 }
        };

        window.onload = function() {
            var hostelSel = document.getElementById("hostelname");
            var floorSel = document.getElementById("floors");
            var roomSel = document.getElementById("roomno");
            
            var courseSel = document.getElementById("course");
            var deptSel = document.getElementById("dept");
            
            for (var x in courseObject) {
                courseSel.options[courseSel.options.length] = new Option(x, x);
            }

            courseSel.onchange = function() {
                deptSel.length = 1;
                var departments = courseObject[this.value];
                for (var i = 0; i < departments.length; i++) {
                    deptSel.options[deptSel.options.length] = new Option(departments[i], departments[i]);
                }
            }
            
            
            hostelSel.onchange = function() {
                // Clear previous options
                floorSel.length = 1;
                roomSel.length = 1;
                var floorLabels = ['G', 'F', 'S', 'T', 'R'];
                var hostel = this.value;
                if (hostel === 'Moyar Hostel')
                {
                    for (var i = 65; i < 65 + hostelData[hostel].blocks; i++) {
                        var option = new Option(String.fromCharCode(i), String.fromCharCode(i));
                        floorSel.options[floorSel.options.length] = option;
                    }
                    for (var i = 1; i <= hostelData[hostel].rooms; i++) {
                        var option = new Option(i, i);
                        roomSel.options[roomSel.options.length] = option;
                    }
                } 
                else 
                {
                    for (var i = 0; i <= hostelData[hostel].floors; i++) {
                            var option = new Option(floorLabels[i],floorLabels[i]);
                            floorSel.options[floorSel.options.length] = option;
                    }
                    for (var i = 1; i <= hostelData[hostel].rooms; i++) {
                        var option = new Option(i, i);
                        roomSel.options[roomSel.options.length] = option;
                    }
                }
            };
        };