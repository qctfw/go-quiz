$(function() {
    const unk = [81, 67, 84, 70, 87, 85, 78, 76, 79, 67, 75];
    const k1 = [68, 68, 76, 67, 80, 76, 65, 89];
	const k2 = [77, 68, 80, 78, 70, 66, 79, 188, 74, 82, 70, 80];
    let k1e;
	let t;
    let k = 0;
    var unnk = 0;
    $(window).keydown(function(e){
        var key = e.which;
        if (k < 1) {
            if (key === unk[unnk])
                unnk++;
            else unnk = 0;
        }
        else {
            if (t === "k1") {
				if (key === k1[unnk]) {
					unnk++;
				}
				else {
					setT(key);
				}
			}
			else if (t === "k2") {
				if (key === k2[unnk]) {
					unnk++;
				}
				else {
					setT(key);
				}
			}
            else {
				setT(key);
			}
        }
        cm();
    });
	function setT(key){
		if (key === k1[0]) {
			t = "k1";
			unnk = 1;
		}
		else if (key === k2[0]) {
			t = "k2";
			unnk = 1;
		}
		else {
			unnk = 0;
		}
	}
    function cm() {
        var maxKeyIndex = unk.length;
        if (k < 1) {
            if(unnk >= maxKeyIndex) {
                console.log('Secret Key Unlocked!');
                k = 1;
                unnk = 0;
            }
        }
        else {
			switch (t) {
				case "k1":
					maxKeyIndex = k1.length;
					if(unnk >= maxKeyIndex) {
						k1e = 'k1e';
						k1f();
						unnk = 0;
					}
				break;
				case "k2":
					maxKeyIndex = k2.length;
					if(unnk >= maxKeyIndex) {
						k1e = 'k1m';
						k1f();
						unnk = 0;
					}
				break;		
			}
        }
    }
    function k1f() {
        $.post('vendor/egg/l.php', {l: k1e}, function(data) {
            $("#blank").append(data);
        });
    }
});