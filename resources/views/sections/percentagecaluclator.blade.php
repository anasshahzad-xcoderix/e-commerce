<style>
    .percentage-calculator {
        max-width: 520px;
        margin: 50px auto;
        padding: 30px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }




    .percentage-calculator h1 {
        margin: 0 0 24px;
        text-align: center;
    }

    .percentage-calculator .field {
        margin-bottom: 16px;
    }

    .percentage-calculator label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .percentage-calculator input {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
    }

    .percentage-calculator button {
        width: 100%;
        padding: 11px;
        border: 0;
        border-radius: 6px;
        background: #e39320;
        color: #fff;
        font-weight: 700;
        cursor: pointer;
    }

    .percentage-calculator .message {
        min-height: 24px;
        margin: 16px 0 0;
        text-align: center;
        font-weight: 700;
    }

    .percentage-calculator .error {
        color: #dc2626;
    }

    .percentage-calculator .result {
        color: #15803d;
        font-size: 22px;
    }
</style>

<section class="percentage-calculator" aria-labelledby="percentage-calculator-title">
    <h1 id="percentage-calculator-title">Percentage Calculator</h1>

    <form id="percentage-calculator-form">
        <div class="field">
            <label for="total-number">Total Number</label>
            <input type="number" id="total-number" min="0" step="any" placeholder="Enter total number">
        </div>

        <div class="field">
            <label for="obtained-number">Obtained Number</label>
            <input type="number" id="obtained-number" min="0" step="any" placeholder="Enter obtained number">
        </div>

        <button type="submit">Calculate</button>
        <p id="percentage-result" class="message" role="status" aria-live="polite"></p>
    </form>
</section>

<script>
$(function () {
    $('#percentage-calculator-form').on('submit', function (event) {
        event.preventDefault();

        const totalText = $('#total-number').val().trim();
        const obtainedText = $('#obtained-number').val().trim();
        const $result = $('#percentage-result');
        $result.removeClass('error result').empty();

        if (totalText === '' || obtainedText === '') {
            $result.addClass('error').text('Please enter both numbers.');
            return;
        }

        const total = Number(totalText);
        const obtained = Number(obtainedText);

        if (!Number.isFinite(total) || !Number.isFinite(obtained) || total < 0 || obtained < 0) {
            $result.addClass('error').text('Please enter valid non-negative numbers.');
            return;
        }
           

    

        if (total === 0) {
            $result.addClass('error').text('Total number must be greater than zero.');
            return;
        }

       


if (obtained > total) {
    $result.addClass('error').text('Obtained number cannot be greater than total number.');
    return;
}
                const percentage = (obtained / total) * 100;
                const formattedPercentage = Number.isInteger(percentage)
                    ? percentage.toString()
                    : percentage.toFixed(2);
        
        $result.addClass('result').text(`Result: ${formattedPercentage}%`);
    });
});
</script>